<?php

namespace dwesgram\modelo;

class Utils
{
    public static function validarImagen(string $id, array $files, string $folder): String|null|bool
    {
        if (
            $files && isset($files[$id]) &&
            $files[$id]['error'] === UPLOAD_ERR_OK &&
            $files[$id]['size'] > 0
        ) {
            $allowedext = array('png', 'jpg');
            $allowedmime = array('image/png', 'image/jpg', 'image/jpeg');
            $filename = $files[$id]['name'];
            $filemime = $files[$id]['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_fichero = finfo_file($finfo, $filemime);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowedext) || !in_array($mime_fichero, $allowedmime)) {
                return false;
            } else {
                $files[$id]['name'] = time() . "." . $ext;
                $rutaFicheroDestino = $folder . basename($files[$id]['name']);

                $seHaSubido = move_uploaded_file($files[$id]['tmp_name'], $rutaFicheroDestino);

                if ($seHaSubido === false) {
                    return false;
                } else {
                    return $folder . $files[$id]['name'];
                }
            }
        } else {
            return false;
        }
    }
}
