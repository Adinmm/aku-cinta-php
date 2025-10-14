<?php

use Aws\S3\S3Client;

/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */


class Files
{

    const type_images = 'images';
    const type_documents = 'documents';
    const type_archives = 'archives';

    public $extension_allowed = array(
        self::type_images => array(
            'image/bmp', 'image/gif', 'image/jpeg', 'image/png'                             // images
        ),
        self::type_documents => array(
            'application/msword',                                                           // .doc
            'application/vnd.ms-powerpoint',                                                // .ppt
            'application/vnd.ms-excel',                                                     // .xls
            'application/vnd.oasis.opendocument.text',                                      // .odt
            'application/vnd.oasis.opendocument.formula',                                   // .odf
            'application/vnd.oasis.opendocument.presentation',                              // .odp
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',      // .docx
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',    // .pptx
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',            // .xlsx
            'application/pdf'                                                               // .pdf
        ),
        self::type_archives => array(
            'application/zip',                                                              // .zip
            'application/octet-stream',                                                     // .zip
            'application/x-zip-compressed',                                                 // .zip
            'multipart/x-zip',                                                              // .zip
            'application/x-rar-compressed',                                                 // .rar
            'application/octet-stream',                                                     // .rar
        )
    );

    /**
     * batas upload maksimum
     */
    public $upload_max_filesize = 10000000; // 10 MB

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    function saveDO($files, $path = '', $extension_type = array(), $prefix_file_name = '')
    {

        $status = false;
        $obj_file = new File();
        $obj_file->init($files);

        $filename = pathinfo($obj_file->get_file_name(), PATHINFO_FILENAME);
        $extension = pathinfo($obj_file->get_file_name(), PATHINFO_EXTENSION);

        $filename = preg_replace('/[^a-zA-Z0-9]/', '_', $filename);
        $filename = $prefix_file_name . '-' . date('Y_m_d') . '-' . strtolower($filename) . '.' . $extension;

        $extension_allowed = false;
        foreach ($extension_type as $ex) {
            if (in_array($obj_file->get_file_type(), $this->extension_allowed[$ex])) {
                $extension_allowed = true;
                break;
            }
        }

        if ('' == $obj_file->get_file_name())
            $messages = 'No file selected, so do nothing.';

        else if ($obj_file->get_file_error() > 0)
            $messages = 'Error occurred, return code : ' . $obj_file->get_file_error();

        else if ($obj_file->get_file_size() > $this->upload_max_filesize)
            $messages = 'File size can not bigger than ' . ($this->upload_max_filesize / 1000000) . ' MB.';

        else if (!$extension_allowed)
            $messages = 'The extension of file ( ' . $extension . ' ) is not allowed.';

        else {

            $s3 = new S3Client([
                'version' => 'latest',
                'region' => DO_SPACE_REGION,
                'endpoint' => DO_SPACE_ENDPOINT,
                'credentials' => ['key' => DO_SPACE_KEY, 'secret' => DO_SPACE_SECRET]
            ]);

            $result = $s3->putObject([
                'ACL' => 'public-read',
                'ContentType' => $obj_file->get_file_type(),
                'Bucket' => DO_SPACE_BUCKET,
                'Key' => DO_SPACE_DIR . DS . $path . DS . $filename,
                'SourceFile' => $obj_file->get_file_tmp_name()
            ]);

            $status = true;
            $messages = 'Success';
            $obj_file->set_file_uri_path($result->get('ObjectURL'));
        }

        return array(
            'status' => $status,
            'messages' => $messages,
            'obj_file' => $obj_file
        );

    }

    function _saveDO($files, $path = '', $extension_type = array(), $prefix_file_name = '')
    {

        $status = false;
        $obj_file = new File();
        $obj_file->init($files);

        $filename = pathinfo($obj_file->get_file_name(), PATHINFO_FILENAME);
        $extension = pathinfo($obj_file->get_file_name(), PATHINFO_EXTENSION);

        $filename = preg_replace('/[^a-zA-Z0-9]/', '_', $filename);
        $filename = $prefix_file_name . '-' . date('Y_m_d') . '-' . strtolower($filename) . '.' . $extension;

        $extension_allowed = false;
        foreach ($extension_type as $ex) {
            if (in_array($obj_file->get_file_type(), $this->extension_allowed[$ex])) {
                $extension_allowed = true;
                break;
            }
        }

        if ('' == $obj_file->get_file_name())
            $messages = 'No file selected, so do nothing.';

        else if ($obj_file->get_file_error() > 0)
            $messages = 'Error occurred, return code : ' . $obj_file->get_file_error();

        else if ($obj_file->get_file_size() > $this->upload_max_filesize)
            $messages = 'File size can not bigger than ' . ($this->upload_max_filesize / 1000000) . ' MB.';

        else if (!$extension_allowed)
            $messages = 'The extension of file ( ' . $extension . ' ) is not allowed.';

        else {

            new S3(DO_SPACE_KEY, DO_SPACE_SECRET, false, DO_SPACE_ENDPOINT);
            S3::putObjectFile($obj_file->get_file_tmp_name(), DO_SPACE_BUCKET, DO_SPACE_DIR . DS . $path . DS . $filename, S3::ACL_PUBLIC_READ);

            $status = true;
            $messages = 'Success';
            $obj_file->set_file_uri_path('https://' . DO_SPACE_ENDPOINT . DS . DO_SPACE_BUCKET . DS . DO_SPACE_DIR . DS . $path . DS . $filename);
        }

        return array(
            'status' => $status,
            'messages' => $messages,
            'obj_file' => $obj_file
        );

    }

}