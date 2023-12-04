<?php 

/**
 * Namespace: Agrupa as interfaces controladoras;
 * @author: R1TKILL;
 */
namespace Controler{

    /**
     * Interface: Interface de conexão, garante a implementação básica para os métodos sql;
     * @author: R1TKILL;
     */
    interface ConnectInterface{

        public function connectDrive(): \PDO;

        public function insertDates(...$fields): void;

        public function readAllDates(): array;

        public function readFilterDate(int $id): array;

        public function updateFilterDate(...$fields): void;

        public function deleteFilterDate(int $id): void;
    }
    
}

?>