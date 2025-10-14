<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class Helpers
{
    const page_404 = '404';
    const page_index = 'index.php';
    const page_header = 'header.php';
    const page_footer = 'footer.php';
    const page_sidebar = 'sidebar.php';

    const page_op = 'op';       // operator prodi
    const page_d = 'd';         // dosen
    const page_m = 'm';         // mahasiswa
    const page_u = 'u';         // umum

    const dir_operator_prodi = 'operator-prodi';
    const dir_dosen = 'dosen';
    const dir_mahasiswa = 'mahasiswa';
    const dir_umum = 'umum';

    const page_beranda = 'beranda';
    const page_api = 'api';
    const page_aksi = 'aksi';
    const page_keluar = 'keluar';
    const page_akun = 'akun';
    const page_detail = 'detail';
    const page_pesan = 'pesan';

    const op_bimbingan = 'bimbingan';
    const op_persetujuan = 'persetujuan';
    const op_pengantar = 'pengantar';
    const op_pengaturan = 'pengaturan';
    const op_pengajuan = 'pengajuan';
    const op_seminar = 'seminar';
    const op_tempat = 'tempat';
    const op_statistik = 'statistik';

    const d_biodata = 'biodata';
    const d_bimbingan = 'bimbingan';
    const d_persetujuan = 'persetujuan';
    const d_pengantar = 'pengantar';
    const d_pengajuan = 'pengajuan';
    const d_surat_tugas = 'surat-tugas';
    const d_seminar = 'seminar';
    const d_tempat = 'tempat';

    const m_biodata = 'biodata';
    const m_bimbingan = 'bimbingan';
    const m_persetujuan = 'persetujuan';
    const m_pengantar = 'pengantar';
    const m_surat_tugas = 'surat-tugas';
    const m_seminar = 'seminar';
    const m_pengajuan = 'pengajuan';
    const m_tempat = 'tempat';

    const api_dosen = 'dosen';
    const api_mahasiswa = 'mahasiswa';
    const api_tanda_tangan = 'tanda-tangan';
    const api_tempat = 'tempat';

    const sso_operator_prodi = 'OP';
    const sso_dosen = 'D';
    const sso_mahasiswa = 'M';

    const status_success = 'sukses';
    const status_failed = 'gagal';

    const verify_unsubmit = -2;
    const verify_default = 0;
    const verify_waiting = 1;
    const verify_success = 2;
    const verify_reject = 3;

    const action = 'aksi';
    const action_add = 'tambah';
    const action_edit = 'perbaiki';
    const action_delete = 'hapus';
    const action_verify = 'verifikasi';
    const action_conf = 'konfirmasi';
    const action_save = 'simpan';
    const action_submit = 'ajukan';
    const action_print = 'cetak';
    const action_grade = 'nilai';
    const action_grade_lock = 'kunci-nilai';
    const action_revise = 'revisi';
    const action_sign = 'tanda-tangan';
    const action_clear = 'bersihkan';
    const action_download = 'unduh';
    const action_upload = 'unggah';
    const action_upload_template = 'unggah-template';
    const action_language = 'bahasa';

    const type_attribute_all = 'all';
    const type_attribute_primary = 'primary';
    const type_attribute_foreign = 'foreign';

    const api_telegram = 'https://api.lrsoft.id/bot/telegram/unram/v1/channel?channel=ifunram';

    const csv_comma = ',';
    const csv_semicolon = ';';

    public static $_status_map = array(
        self::status_success,
        self::status_failed
    );

    public static $_status_class_map = array(
        self::status_success => 'success',
        self::status_failed => 'danger'
    );

    public static $_status_icon_map = array(
        self::status_success => 'fa fa-check',
        self::status_failed => 'fa fa-warning'
    );

    static $_dir_map = array(
        self::page_op => self::dir_operator_prodi,
        self::page_d => self::dir_dosen,
        self::page_m => self::dir_mahasiswa,
    );

    static $_dir_default_page_map = array(
        self::dir_operator_prodi => self::page_op . DS . self::op_pengaturan,
        self::dir_dosen => self::page_d . DS . self::d_biodata,
        self::dir_mahasiswa => self::page_m . DS . self::m_biodata,
    );

    static function _header()
    {
        require_once ABS_VIEW_PATH . DS . self::page_header;
    }

    static function _footer()
    {
        require_once ABS_VIEW_PATH . DS . self::page_footer;
    }

    static function _sidebar($sub = '')
    {
        require_once ABS_VIEW_PATH . DS . (empty($sub) ? '' : $sub . DS) . self::page_sidebar;
    }


    static function _a($page)
    {
        return URI_PATH . DS . self::page_index . DS . $page;
    }

    static function _a_op($sub_page, $action = false)
    {
        return self::_a(self::page_op . DS . ($action ? self::page_aksi . DS : '') . $sub_page);
    }

    static function _a_d($sub_page, $action = false)
    {
        return self::_a(self::page_d . DS . ($action ? self::page_aksi . DS : '') . $sub_page);
    }

    static function _a_m($sub_page, $action = false)
    {
        return self::_a(self::page_m . DS . ($action ? self::page_aksi . DS : '') . $sub_page);
    }

    static function _a_u($sub_page, $action = false)
    {
        return self::_a(self::page_u . DS . ($action ? self::page_aksi . DS : '') . $sub_page);
    }


    static function _api($service)
    {
        return self::_a(self::page_api . DS . $service);
    }

    static function _sso($logout = false)
    {
        return SSO_URI . DS . 'auth' . DS . SSO_SERVICE . ($logout ? '?logout' : '');
    }


    public static function _breadcrumb($page = '')
    {
        $_tmp = '<ol class="breadcrumb">';
        $_tmp .= '<li><a href="' . URI_PATH . '">Beranda</a></li>';
        if (strtolower($page) != self::page_beranda) {
            if ($page == self::page_404)
                $_tmp .= '<li>404</li>';
            else {
                foreach (Routes::_gi()->_depths() as $_i => $_depth) {
                    if ($_i == 0) continue;
                    $_tmp .= '<li ' . (strtolower($page) == $_depth ? 'class="active"' : '') . '>' . self::_camel_case($_depth) . '</li>';
                }

            }
        }
        $_tmp .= '</ol>';
        return $_tmp;
    }

    static function _camel_case($string, $delimiter = '-', $separator = ' ', $min_length = 3)
    {
        return implode(array_map(function ($x) use ($separator, $min_length) {
            return (strlen($x) <= $min_length ? strtoupper($x) : ucfirst($x)) . $separator;
        }, explode($delimiter, $string)));
    }

    static function _filter_class_attr($attributes, $type = self::type_attribute_primary, $additional_exclude = array())
    {
        return array_filter($attributes, function ($v) use ($type, $additional_exclude) {
            switch ($type) {
                case self::type_attribute_primary :
                    return substr($v, 0, 1) != '_' && !in_array($v, $additional_exclude);
                    break;
                case self::type_attribute_foreign :
                    return substr($v, 0, 1) == '_' && !in_array($v, $additional_exclude);
                    break;
                case self::type_attribute_all :
                default:
                    return !in_array($v, $additional_exclude);
            }
        });
    }

    static function _class_name($class_path)
    {
        return $class_path;

        /**
         * saat ini tidak pakai namespace, jadi
         * langsung muncul nama class
         *
         * return substr(strrchr($class_path, '\\'), 1);
         */
    }

    static function _model_path($class_path)
    {
        return __NAMESPACE__ . '\\M' .
            self::_trim_first_char(
                self::_class_name($class_path), 'C'
            );
    }

    static function _model_name($class_path)
    {
        return 'M' . self::_trim_first_char(
                self::_class_name($class_path), 'C'
            );
    }

    static function _table_name($class_path, $type = 'C')
    {
        return strtolower(
            self::_trim_first_char(
                self::_class_name($class_path)
                , $type)
        );
    }

    static function _trim_first_char($str, $char)
    {
        return substr($str, 0, 1) == $char ?
            substr($str, 1) : $str;
    }

    static function _to_array($vars, $type = self::type_attribute_all, $exclude = array())
    {
        $_out = array();
        $_keys = self::_filter_class_attr(array_keys($vars), $type, $exclude);
        foreach ($_keys as $_key)
            $_out[$_key] = is_null($vars[$_key]) ? '' : $vars[$_key];
        return $_out;
    }

    /**
     * Sync default args dengan array yg diberikan
     *
     * @param $default
     * @param $destination
     * @return array
     */
    static function _params($default, $destination)
    {
        $return = array();
        foreach ($default as $k => $d) {
            if (isset($destination[$k])) {
                $_tmp = $destination[$k];
                if (isset($_GET[$k]))
                    $_tmp = self::_sanitize($_tmp);
                $return[$k] = $_tmp;
            } else $return[$k] = $d;
        }
        return $return;
    }

    static function _sanitize($str)
    {
        return str_replace(array('&', '<', '>', '/', '\\', '"', "'", '?', '+', '`'), '', $str);
    }

    static function _sanitize2($str)
    {
        return preg_replace('/[^0-9a-zA-Z ]/', '', $str);
    }

    /**
     * @param $field
     * @return bool
     */
    static function _empty($field)
    {
        return is_null($field) || empty($field);
    }

    /**
     * @param $array
     * @param $key
     * @param string $default
     * @return int|string|array
     */
    static function _arr($array, $key, $default = '')
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    static function _notif_crud($action, $status, $message = '')
    {
        $message = str_replace('{{action}}', $action, $message);
        $message = str_replace('{{status}}', $status, $message);
        return in_array($status, self::$_status_map) ? '<div class="alert alert-' . self::$_status_class_map[$status] . ' alert-dismissible">' .
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' .
            '<i class="icon ' . self::$_status_icon_map[$status] . '"></i>&nbsp;&nbsp;' . $message . '</div>' : '';
    }

    static function _paging($base_url, $total_data, $current_page, $data_per_page = 10, $range_data = 3)
    {

        $out = '<span class="text-muted">' . number_format($total_data) . ' Item' . ($total_data > 1 ? 's' : '') . '</span>';

        /** cek apakah memungkinkan untuk paging */
        if ($total_data > $data_per_page && $data_per_page > 0) {
            $total_page = ceil($total_data / $data_per_page);

            /** batas minimum */
            $ii = ($ii = $current_page - $range_data) < 1 ? 1 : $ii;

            /** batas maksimum */
            $iii = ($iii = $current_page + $range_data) > $total_page ? $total_page : $iii;

            $out .= '<ul class="pagination pagination-sm no-margin pull-right">';

            /** tampilkan left arrow */
            if ($current_page == 1)
                $out .= '<li><span>&laquo;</span></li>';
            else
                $out .= '<li><a href="' . $base_url . '&page=1">&laquo;</a></li>';

            /** jika tidak mepet dengan nilai minimum, tampilkan titik-titik */
            if ($ii != 1)
                $out .= '<li><span>...</span></li>';

            /** mulai iterasi sesuai range yang telah ditentukan */
            for ($i = $ii; $i <= $iii; $i++)
                $out .= '<li class="' . ($current_page == $i ? 'active' : '') . '">' .
                    '<a href="' . $base_url . '&page=' . $i . '">' . $i . '</a></li>';

            /** jika tidak mepet dengan nilai maksimum, tampilkan titik-titik */
            if ($iii != $total_page)
                $out .= '<li><span>...</span></li>';

            /** tampilkan right arrow */
            if ($current_page == $total_page)
                $out .= '<li><span>&raquo;</span></li>';
            else
                $out .= '<li><a href="' . $base_url . '&page=' . $total_page . '">&raquo;</a></li>';

            $out .= '</ul>';

        }

        return $out;
    }

    static function _minify_HTML_output($buffer)
    {

        /** hanya berlaku pada tag HTML */
        if (preg_match('/\<html/i', $buffer) == 1
            && preg_match('/\<\/html\>/i', $buffer) == 1)
            $buffer = preg_replace(array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'), array('>', '<', '\\1'), $buffer);

        return $buffer;
    }

    static function _redirect($target = URI_PATH)
    {
        header('Location: ' . $target);
        die();
    }

    static function _banner1($msg = '')
    {
        $out = '<!-- =====================================================' . PHP_EOL;
        $out .= '                                                _     _ 
  _   _ _ __  _ __ __ _ _ __ ___    __ _  ___  (_) __| |
 | | | | \'_ \| \'__/ _` | \'_ ` _ \  / _` |/ __| | |/ _` |
 | |_| | | | | | | (_| | | | | | || (_| | (__ _| | (_| |
  \__,_|_| |_|_|  \__,_|_| |_| |_(_)__,_|\___(_)_|\__,_|' . PHP_EOL . PHP_EOL;
        return $out . $msg . '===================================================== -->' . PHP_EOL . PHP_EOL;
    }

    static function _banner2()
    {
        $msg = '  Hai Devs,' . PHP_EOL . PHP_EOL;
        $msg .= '  Kami di PUSTIK UNRAM butuh geek seperti kamu lho!' . PHP_EOL;
        $msg .= '  Yuk join, kirim email ke pustik[at]unram.ac.id  (:' . PHP_EOL . PHP_EOL;
        return self::_banner1($msg);
    }

    static function _is_SSL_URI()
    {
        return strpos(strtolower(URI_PATH), 'https://') !== false;
    }

    static function _is_SSL_request()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
    }

    static function _validate_URI($server)
    {

        if (self::_is_SSL_URI() && !self::_is_SSL_request())
            self::_redirect('https://' . $server['SERVER_NAME'] . $server['REQUEST_URI']);

    }

    static function _idr($x)
    {
        return 'Rp. ' . number_format($x);
    }

    static function _rand_pass($length = 6)
    {
        return strtoupper(substr(md5(rand(1, 100)), 0, $length));
    }

    static function _char_to_num($char)
    {
        return $char ? (ord(strtolower($char)) - 96) : 0;
    }

    static function _date($str, $format = 'Y-m-d')
    {
        if (is_null($str) || $str == '0000-00-00' || strlen($str) != 10)
            $str = '1000-01-01';

        $str = str_replace('/', '-', $str);
        return date($format, strtotime($str));
    }

    static function _valid_nim($nim)
    {
        return preg_match('/^[A-Z][0-3][A-Z][0-9]{6}$/i', $nim);
    }

    static function _parse_tahun_akademik($tahun_akademik, $is_upper = false)
    {
        list($_tahun, $_semester) = str_split($tahun_akademik, 4);
        switch ($_semester) {
            case '1':
                $_tahun .= ' (Gasal)';
                break;
            case '2':
                $_tahun .= ' (Genap)';
                break;
        }
        return $is_upper ? strtoupper($_tahun) : $_tahun;
    }

    static function __($str, $camel_case = false)
    {
        $_dictionaries = array(
            // days
            'sunday' => 'minggu',
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',

            // months
            'january' => 'januari',
            'february' => 'februari',
            'march' => 'maret',
            'april' => 'april',
            'may' => 'mei',
            'june' => 'juni',
            'july' => 'juli',
            'august' => 'agustus',
            'september' => 'september',
            'october' => 'oktober',
            'november' => 'november',
            'december' => 'desember'
        );

        $_tmp = preg_replace_callback('!(\w+)!',
            function ($matches) use ($_dictionaries) {
                return self::_arr($_dictionaries, strtolower($matches[1]), $matches[1]);
            }, $str);

        return $camel_case ? self::_camel_case($_tmp, ' ') : $_tmp;
    }

    static function _fetch($url, $decode = true)
    {
        $_response = file_get_contents($url, false, stream_context_create(array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false
            )
        )));
        return $decode ? json_decode($_response, true) : $_response;
    }

    static function _signature_verify($token, $data, $key)
    {
        return $token === hash_hmac('sha256', json_encode($data), $key);
    }

    static function _send_tg($data, $target = self::api_telegram)
    {
        return file_get_contents($target . '&' . http_build_query($data));
    }

    static function _send_tg_notif($_jenis, $_nama, $_nim, $_status)
    {
        self::_send_tg([
            'messages' => sprintf('*PKL* - Pengajuan *%s* dari *%s* (%s) status *%s*.',
                $_jenis, $_nama, $_nim, $_status)
        ]);

    }

    static function _li_lang()
    {
        $_lang_active = Sessions::_gi()->_lang_get(); ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img alt="<?php echo $_lang_active; ?>"
                     src="<?php printf('%s/lang/%s.svg', URI_IMG_PATH, $_lang_active); ?>"
                     width="16px"/>
                &nbsp;<span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <?php foreach (i18n::$_lang as $_k => $_v) : ?>
                    <li>
                        <a href="<?php echo Helpers::_a_u(Helpers::action_language . DS . $_k, true) . '?redirect=' . Routes::_gi()->_uri(); ?>">
                            <img alt="<?php echo $_v; ?>"
                                 src="<?php printf('%s/lang/%s.svg', URI_IMG_PATH, $_k); ?>"
                                 width="16px"/>
                            &nbsp;<?php echo $_v; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php
    }

}