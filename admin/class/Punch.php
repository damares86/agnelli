<?php

##############    Damares    ###############
#                                          #
#    Estensione Timbrature - Timbrature    #
#                                          #
############################################

class Punch extends Common
{
    public $table = "punch";
    public $employee_id;
    public $punch_date;
    public $punch_time;
    public $source;

    /* inserimento idempotente: la UNIQUE evita i doppioni al reimport */
    public function add($employeeId, $date, $time, $source)
    {
        $sql = "INSERT IGNORE INTO " . $this->prx . "punch
                (employee_id, punch_date, punch_time, source)
                VALUES (:employee_id, :punch_date, :punch_time, :source)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":employee_id", $employeeId);
        $stmt->bindParam(":punch_date", $date);
        $stmt->bindParam(":punch_time", $time);
        $stmt->bindParam(":source", $source);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /* tutte le timbrature del mese raggruppate: [employee_id][Y-m-d] = [ 'HH:MM:SS', ... ] */
    public function monthGrouped($year, $month, $employeeId = null)
    {
        $from = sprintf('%04d-%02d-01', $year, $month);
        $to   = date('Y-m-t', strtotime($from));

        $sql = "SELECT employee_id, punch_date, punch_time FROM " . $this->prx . "punch
                WHERE punch_date BETWEEN :from AND :to";
        if ($employeeId) {
            $sql .= " AND employee_id = :eid";
        }
        $sql .= " ORDER BY employee_id, punch_date, punch_time";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":from", $from);
        $stmt->bindParam(":to", $to);
        if ($employeeId) {
            $stmt->bindParam(":eid", $employeeId);
        }
        $stmt->execute();

        $out = [];
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $out[$r['employee_id']][$r['punch_date']][] = $r['punch_time'];
        }
        return $out;
    }

    /* mesi disponibili per la select */
    public function availableMonths()
    {
        $sql = "SELECT DATE_FORMAT(punch_date,'%Y-%m') AS ym, COUNT(*) AS tot
                FROM " . $this->prx . "punch GROUP BY ym ORDER BY ym DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMonth($year, $month)
    {
        $from = sprintf('%04d-%02d-01', $year, $month);
        $to   = date('Y-m-t', strtotime($from));
        $stmt = $this->conn->prepare("DELETE FROM " . $this->prx . "punch WHERE punch_date BETWEEN :from AND :to");
        $stmt->bindParam(":from", $from);
        $stmt->bindParam(":to", $to);
        return $stmt->execute();
    }

    /* ------------------------------------------------------------------
       Accoppiamento entrate/uscite di una giornata.
       Le timbrature sono in ordine crescente: 1a=entrata, 2a=uscita,
       3a=entrata, 4a=uscita ... (gestisce la pausa pranzo e turni multipli).
       Ritorna ['pairs'=>[[in,out],...], 'hours'=>float, 'odd'=>bool]
       ------------------------------------------------------------------ */
    public static function buildDay(array $times)
    {
        sort($times);
        $pairs = [];
        $seconds = 0;
        $odd = false;

        for ($i = 0; $i < count($times); $i += 2) {
            $in = $times[$i];
            $out = isset($times[$i + 1]) ? $times[$i + 1] : null;
            if ($out === null) {
                $odd = true;
                $pairs[] = [$in, null];
                break;
            }
            $pairs[] = [$in, $out];
            $seconds += max(0, strtotime($out) - strtotime($in));
        }

        return [
            'pairs' => $pairs,
            'hours' => round($seconds / 3600, 2),
            'odd'   => $odd,
        ];
    }

    public static function hhmm($decimalHours)
    {
        $sign = $decimalHours < 0 ? '-' : '';
        $decimalHours = abs($decimalHours);
        $h = floor($decimalHours);
        $m = (int) round(($decimalHours - $h) * 60);
        if ($m === 60) {
            $h++;
            $m = 0;
        }
        return sprintf('%s%d:%02d', $sign, $h, $m);
    }
}
