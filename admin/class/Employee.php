<?php

##############    Damares    ###############
#                                          #
#    Estensione Timbrature - Dipendenti    #
#                                          #
############################################

class Employee extends Common
{
    public $table = "employee";
    public $name;
    public $badge;
    public $h_mon;
    public $h_tue;
    public $h_wed;
    public $h_thu;
    public $h_fri;
    public $active;
    public $notes;

    public function fields()
    {
        return ['name', 'badge', 'h_mon', 'h_tue', 'h_wed', 'h_thu', 'h_fri', 'active', 'notes'];
    }

    /* elenco completo (array) ordinato per nome */
    public function allEmployees($onlyActive = false)
    {
        $sql = "SELECT * FROM " . $this->prx . "employee";
        if ($onlyActive) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->prx . "employee WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* cerca per badge oppure per nome (case insensitive, spazi normalizzati) */
    public function findByBadgeOrName($badge, $name)
    {
        if ($badge !== null && $badge !== '') {
            $stmt = $this->conn->prepare("SELECT * FROM " . $this->prx . "employee WHERE badge = :badge LIMIT 1");
            $stmt->bindParam(":badge", $badge);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row;
            }
        }
        $clean = preg_replace('/\s+/', ' ', trim($name));
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->prx . "employee
            WHERE LOWER(TRIM(name)) = LOWER(:name) LIMIT 1");
        $stmt->bindParam(":name", $clean);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* crea al volo un dipendente trovato nelle timbrature ma non in anagrafica */
    public function quickCreate($name, $badge)
    {
        $clean = preg_replace('/\s+/', ' ', trim($name));
        $stmt = $this->conn->prepare("INSERT INTO " . $this->prx . "employee
            (name, badge, h_mon, h_tue, h_wed, h_thu, h_fri, active)
            VALUES (:name, :badge, 8, 8, 8, 8, 8, 1)");
        $stmt->bindParam(":name", $clean);
        $stmt->bindParam(":badge", $badge);
        $stmt->execute();
        return (int) $this->conn->lastInsertId();
    }

    /* ore contrattuali per giorno della settimana ISO (1=lun ... 7=dom) */
    public static function contractHours($row, $isoDay)
    {
        $map = [1 => 'h_mon', 2 => 'h_tue', 3 => 'h_wed', 4 => 'h_thu', 5 => 'h_fri'];
        if (!isset($map[$isoDay])) {
            return 0.0;
        }
        return (float) $row[$map[$isoDay]];
    }

    public static function weekTotal($row)
    {
        return (float) $row['h_mon'] + (float) $row['h_tue'] + (float) $row['h_wed']
            + (float) $row['h_thu'] + (float) $row['h_fri'];
    }
}
