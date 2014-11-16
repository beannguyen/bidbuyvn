<?php
require('./library/paranoia.class.php');
define('nl', "\r\n");

class Dbtool_Model extends Model
{
    // member varialbes
    private $tables = array();
    private $suffix = 'd-M-Y_H-i-s';
    private $link;

    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->db->connect();
        $this->link = $this->db->getLink();
    }

    /**
     * dbTools::doBackup()
     *
     * @param string $fname
     * @param bool $gzip
     * @return
     */
    function doBackup($fname = '', $gzip = true)
    {
        echo $fname;
        if (!($sql = $this->fetch())) {
            return false;
        } else {
            $fname = URL::getPath() . '/public/uploads/backups/';

            $savename = (!empty($_POST['name']) ? $fname . paranoia($_POST['name']) . '.sql' : $fname . date($this->suffix).'.sql');
            $bname = !empty($_POST['name']) ? paranoia($_POST['name']) . '.sql' : date($this->suffix).'.sql';

            $save = $this->save($savename, $sql, $gzip = 0);

            if ($save) {
                URL::redirect_to(URL::get_site_url()."/dashboard/general_setting?dobackup=done");
            }
        }
    }

    /**
     * dbTools::doRestore()
     *
     * @param string $fname
     * @return
     */
    function doRestore($fname)
    {
        $filename = URL::getPath() . '/public/uploads/backups/'.trim($fname);
        $templine = '';
        $lines = file($filename);
        foreach ($lines as $line_num => $line) {
            if (substr($line, 0, 2) != '--' && $line != '') {
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {
                    if (!$this->db->query($templine)) {
                        $msgError =  "<div class=\"qerror\">'".mysqli_errno($this->link)." ".mysqli_error($this->link)."' during the following query:</div>
						  <div class=\"query\">{$templine} </div>";

                        $reqsURL = URL::get_site_url().'/error/errHandler';
                        $data = array(
                            'error' => $msgError
                        );
                        URL::http_request($reqsURL, $data);
                    }
                    $templine = '';
                }
            }
        }
        URL::redirect_to(URL::get_site_url()."/dashboard/general_setting?dorestore=done");
    }

    /**
     * dbTools::getTables()
     *
     * @return
     */
    function getTables()
    {
        $value = array();
        if (!($result = $this->db->query('SHOW TABLES'))) {
            return false;
        }
        while ($row = $this->db->fetchrow($result)) {
            if (empty($this->tables) or in_array($row[0], $this->tables)) {
                $value[] = $row[0];
            }
        }
        if (!sizeof($value)) {
            $this->db->error("No tables found in database");
            return false;
        }
        return $value;
    }


    /**
     * dbTools::dumpTable()
     *
     * @param mixed $table
     * @return
     */
    function dumpTable($table)
    {
        $damp = '';
        $this->db->query('LOCK TABLES ' . $table . ' WRITE');

        $damp .= '-- --------------------------------------------------' . nl;
        $damp .= '# -- Table structure for table `' . $table . '`' . nl;
        $damp .= '-- --------------------------------------------------' . nl;
        $damp .= 'DROP TABLE IF EXISTS `' . $table . '`;' . nl;

        if (!($result = $this->db->query('SHOW CREATE TABLE ' . $table))) {
            return false;
        }
        $row = $this->db->fetch($result);
        $damp .= str_replace("\n", nl, $row['Create Table']) . ';';
        $damp .= nl . nl;
        $damp .= '-- --------------------------------------------------' . nl;
        $damp .= '# Dumping data for table `' . $table . '`' . nl;
        $damp .= '-- --------------------------------------------------' . nl . nl;
        $damp .= $this->insert($table);
        $damp .= nl . nl;
        $this->db->query('UNLOCK TABLES');
        return $damp;
    }

    /**
     * dbTools::insert()
     *
     * @param mixed $table
     * @return
     */
    function insert($table)
    {
        $output = '';
        if (!$query = $this->db->fetch_all("SELECT * FROM `" . $table . "`")) {
            return false;
        }
        foreach ($query as $result) {
            $fields = '';

            foreach (array_keys($result) as $value) {
                $fields .= '`' . $value . '`, ';
            }
            $values = '';

            foreach (array_values($result) as $value) {
                $value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
                $value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
                $value = str_replace('\\', '\\\\', $value);
                $value = str_replace('\'', '\\\'', $value);
                $value = str_replace('\\\n', '\n', $value);
                $value = str_replace('\\\r', '\r', $value);
                $value = str_replace('\\\t', '\t', $value);

                $values .= '\'' . $value . '\', ';
            }

            $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
        }
        return $output;
    }

    /**
     * dbTools::fetch()
     *
     * @return
     */
    function fetch()
    {
        $dump = '';

        $database = $this->db->getDB();
        $server = $this->db->getServer();

        $dump .= '-- --------------------------------------------------------------------------------' . nl;
        $dump .= '-- ' . nl;
        $dump .= '-- @version: ' . $database . '.sql ' . date('M j, Y') . ' ' . date('H:i') . ' gewa' . nl;
        $dump .= '-- @package Infinity Framework' . nl;
        $dump .= '-- @author dev.izstore.net.' . nl;
        $dump .= '-- @copyright 2014' . nl;
        $dump .= '-- ' . nl;
        $dump .= '-- --------------------------------------------------------------------------------' . nl;
        $dump .= '-- Host: ' . $server . nl;
        $dump .= '-- Database: ' . $database . nl;
        $dump .= '-- Time: ' . date('M j, Y') . '-' . date('H:i') . nl;
        $dump .= '-- MySQL version: ' . mysqli_get_server_info($this->link) . nl;
        $dump .= '-- PHP version: ' . phpversion() . nl;
        $dump .= '-- --------------------------------------------------------------------------------' . nl . nl;

        $database = $this->db->getDB();
        if (!empty($database)) {
            $dump .= '#' . nl;
            $dump .= '# Database: `' . $database . '`' . nl;
        }
        $dump .= '#' . nl . nl . nl;

        if (!($tables = $this->getTables())) {
            return false;
        }
        foreach ($tables as $table) {
            if (!($table_dump = $this->dumpTable($table))) {
                $this->db->error("mySQL Error : ");
                return false;
            }
            $dump .= $table_dump;
        }
        return $dump;
    }

    /**
     * dbTools::save()
     *
     * @param mixed $fname
     * @param mixed $sql
     * @param mixed $gzip
     * @return
     */
    function save($fname, $sql, $gzip)
    {
        if ($gzip) {
            if (!($zf = gzopen($fname, 'w9'))) {
                $msgError = "<span>Error!</span>can not write to " . $fname;

                $reqsURL = URL::get_site_url().'/error/errHandler';
                $data = array(
                    'error' => $msgError
                );
                URL::http_request($reqsURL, $data);
                return false;
            }
            gzwrite($zf, $sql);
            gzclose($zf);
        } else {
            if (!($f = fopen($fname, 'w'))) {
                $msgError = "<span>Error!</span>can not write to " . $fname;

                $reqsURL = URL::get_site_url().'/error/errHandler';
                $data = array(
                    'errName' => 'Không lưu được file',
                    'error' => $msgError
                );
                URL::http_request($reqsURL, $data);
                return false;
            }
            fwrite($f, $sql);
            fclose($f);
        }
        return true;
    }

    /**
     * dbTools::showTables()
     *
     * @param mixed $dbtable
     * @return
     */
    function showTables($dbtable)
    {
        $database = $this->db->getDB();

        $sql = "SHOW TABLES FROM " . $database;
        $result = $this->db->query($sql);
        $show = '';

        while ($row = $this->db->fetchrow($result))
            : $selected = ($row[0] == $dbtable) ? " selected=\"selected\"" : "";
            $show .= "<option value=\"" . $row[0] . "\"" . $selected . ">" . $row[0] . "</option>\n";
        endwhile;

        $this->db->free($result);

        return($show);
    }

    /**
     * dbTools::displayTable()
     *
     * @param mixed $dbtable
     * @return
     */
    function displayTable($dbtable)
    {
        if (isset($dbtable)) {
            if (!empty($dbtable)) {
                $result = $this->db->query("SELECT * FROM " . $dbtable);
                $fields = $this->db->numfields($result);
                $rows = $this->db->numrows($result);
                $k = 0;
                $dbtable = mysql_field_table($result, $k);
                $display = '';
                $display .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="display">';
                $display .= '<thead>';
                $display .= '<tr>';
                $display .= '<td colspan="4">' . lang('SYS_TBL_PROP') . ' &rsaquo; ' . $dbtable . '</td>';
                $display .= "</tr>\n";
                $display .= '</thead>';
                $display .= '<tr>';
                $display .= '<th>' . lang('FIELD') . ' ' . lang('NAME') . '</th>';
                $display .= '<th>' . lang('FIELD') . ' ' . lang('TYPE') . '</th>';
                $display .= '<th>' . lang('FIELD') . ' ' . lang('LENGHT') . '</th>';
                $display .= '<th>' . lang('FIELD') . ' ' . lang('FLAGS') . '</th>';
                $display .= "</tr>\n";

                $alt = '0';
                $display .= '<tbody>';
                while ($k < $fields) {
                    $col = ($alt % 2) ? 'odd' : 'even';
                    $alt++;

                    $display .= '<tr class="' . $col . '">';
                    $name = mysql_field_name($result, $k);
                    $type = mysql_field_type($result, $k);
                    $len = mysql_field_len($result, $k);
                    $flags = mysql_field_flags($result, $k);

                    $display .= '<td>' . $name . '</td>';
                    $display .= '<td>' . $type . '</td>';
                    $display .= '<td>' . $len . '</td>';
                    $display .= '<td>' . $flags . '</td>';
                    $k++;
                    $display .= "</tr>\n";
                }
                $display .= '</tbody></table>';
            }
            return $display;
        }
    }

    /**
     * dbTools::optimizeDb()
     *
     * @return
     */
    public function optimizeDb()
    {
        $database = $this->db->getDB();

        $display = '';
        $display .= '<table class="forms">';
        $display .= '<thead><tr>';
        $display .= '<th colspan="4">Database ' . $database . '</th>';
        $display .= '</tr>';
        $display .= '<tr>';
        $display .= '<th colspan="2">Repairing... </th>';
        $display .= '<th colspan="2">Optimizing... </th>';
        $display .= '</tr></thead><tbody>';

        $sql = "SHOW TABLES FROM " . $database;
        $result2 = $this->db->query($sql);
        while ($row = $this->db->fetchrow($result2)) {
            $table = $row[0];

            $display .= '<tr>';
            $display .= '<th>' . $table . '</th>';
            $display .= '<td class="right">';

            $sql = "REPAIR TABLE `" . $table . "`";
            $result = $this->db->query($sql);
            if (!$result) {
                $this->db->error("mySQL Error on Query : " . $sql);
            } else
                $display .= '<img src="' . ADMINURL . '/images/yes.png" title="Table ' . $table . ' Repaired" alt="Ok" class="tooltip" />';

            $display .= '</td>';
            $display .= '<th>' . $table . '</th>';
            $display .= '<td class="right">';

            $sql = "OPTIMIZE TABLE `" . $table . "`";
            $result = $this->db->query($sql);
            if (!$result) {
                $this->db->error("mySQL Error on Query : " . $sql);
            } else
                $display .= '<img src="' . ADMINURL . '/images/yes.png" title="Table ' . $table . ' Optimized" alt="Ok" class="tooltip" />';

            $display .= '</td></tr>';
        }
        $display .= '</tbody></table>';

        return $display;
    }
}