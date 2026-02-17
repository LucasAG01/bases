<?php

// Si queremos todos los juagadores, ncesito Conexion, Query SELECT y fetchAll

namespace App;

use PDO;

class Jugador
{

    public static function getJugadores()
    {
        $pdo = Conexion::getConexion();
        $sql = "SELECT * FROM jugadores";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // dornal puede ser null, por eso el ?int
    public static function insertar(string $nombre, string $apellidos, ?int $dorsal, string $posicion, string $barcode): bool
    {

        $pdo = Conexion::getConexion();

        $sql = "INSERT INTO jugadores (nombre, apellidos, dorsal, posicion, barcode) VALUES (:nombre, :apellidos, :dorsal, :posicion, :barcode)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':dorsal' => $dorsal,
            ':posicion' => $posicion,
            ':barcode' => $barcode
        ]);
    }


    public static function existeDorsal(int $dorsal): bool
    {
        $pdo = Conexion::getConexion();

        $sql = "SELECT COUNT(*) FROM jugadores WHERE dorsal = :dorsal";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':dorsal' => $dorsal]);

        return $stmt->fetchColumn() > 0;
    }

    public static function existeBarcode(string $barcode): bool
    {
        $pdo = Conexion::getConexion();

        $sql = "SELECT COUNT(*) FROM jugadores WHERE barcode = :barcode";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':barcode' => $barcode]);

        return $stmt->fetchColumn() > 0;
    }


    public static function generarEAN13(): string
{
    do {
        // 12 dígitos base
        $base = '';
        for ($i = 0; $i < 12; $i++) {
            $base .= random_int(0, 9);
        }

        // calcular dígito control
        $suma = 0;
        for ($i = 0; $i < 12; $i++) {
            $dig = (int)$base[$i];
            $suma += ($i % 2 === 0) ? $dig : $dig * 3;
        }

        $control = (10 - ($suma % 10)) % 10;
        $codigoFinal = $base . $control; // 13 dígitos

    } while (self::existeBarcode($codigoFinal));

    return $codigoFinal;
}


}
