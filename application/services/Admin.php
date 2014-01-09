<?php
    namespace ThinService;

    class Admin
    {
        public static function makeSaisons($j = null)
        {
            $field = (null === $j) ? 'num' : 'crudSearchValue_' . $j;
            $html   = '';
            if (null === $j) {
            $html   .= '<div class="control-group">
                                    <label class="control-label" for="' . $field . '">Numéro</label>
                                    <div class="controls">';
            }
            $html   .= '<select required name="' . $field . '" id="' . $field . '"><option value="">Choisir</option>';
            $num    = (null !== request()->getNum()) ? request()->getNum() : '';
            for ($i = 1 ; $i <= 100 ; $i++) {
                if ($i <> $num) {
                    $html .= '<option value="Saison ' . $i . '">Saison ' . $i . '</option>';
                } else {
                    $html .= '<option value="Saison ' . $i . '" selected>Saison ' . $i . '</option>';
                }
            }
            $html .= '</select>';
            if (null === $j) {
            $html .= '
                                    </div>
                                </div>';
            }
            return $html;
        }

        public static function makeEpisodes($j = null)
        {
            $field  = (null === $j) ? 'num' : 'crudSearchValue_' . $j;
            $html   = '';
            if (null === $j) {
            $html   .= '<div class="control-group">
                                    <label class="control-label" for="' . $field . '">Numéro</label>
                                    <div class="controls">';
            }
            $html   .= '<select required name="' . $field . '" id="' . $field . '"><option value="">Choisir</option>';
            $num    = (null !== request()->getNum()) ? request()->getNum() : '';
            for ($i = 1 ; $i <= 300 ; $i++) {
                if ($i <> $num) {
                    $html .= '<option value="Episode ' . $i . '">Episode ' . $i . '</option>';
                } else {
                    $html .= '<option value="Episode ' . $i . '" selected>Episode ' . $i . '</option>';
                }
            }
            $html .= '</select>';
            if (null === $j) {
                $html .= '
                                    </div>
                                </div>';
            }
            return $html;
        }

        public static function vocabulary(array $data, $id, $label, $required = true, $i = null)
        {
            $html   = '';
            if (null === $i) {
            $html   .= '<div class="control-group">
                                    <label class="control-label" for="' . $id . '">' . $label . '</label>
                                    <div class="controls">';
            }

            $require = (true === $required && null === $i) ? 'required' : '';
            $id = (null === $i) ? $id : 'crudSearchValue_' . $i;

            $html   .= '<select ' . $require . ' name="' . $id . '" id="' . $id . '"><option value="">Choisir</option>';
            $val    = (null !== request()->$id) ? request()->$id : '';

            foreach ($data as $key => $value) {
                if ($value <> $val) {
                    $html .= '<option value="' . $key . '">' . $value . '</option>';
                } else {
                    $html .= '<option value="' . $key . '"> selected' . $value . '</option>';
                }
            }
            $html .= '</select>';
            if (null === $i) {
                $html .= '
                                    </div>
                                </div>';
            }
            return $html;
        }

        public static function exportPdf($data, $type)
        {
            $settings       = \Thin\Data::$_settings[$type];
            $fields         = \Thin\Data::$_fields[$type];

            $pdf = '<html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <link href="//fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css" />
            <title>Extraction ' . $type . '</title>
            <style>
                *
                {
                    font-family: Abel, ubuntu, verdana, tahoma, arial, sans serif;
                    font-size: 11px;
                }
                h1
                {
                    text-transform: uppercase;
                    font-size: 135%;
                }
                th
                {
                    font-size: 120%;
                    color: #fff;
                    background-color: #394755;
                    text-transform: uppercase;
                }
                td
                {
                    border: solid 1px #394755;
                }

                a, a:visited, a:hover
                {
                    color: #000;
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <center><h1>Extraction &laquo ' . $type . ' &raquo;</h1></center>
            <p></p>
            <table width="100%" cellpadding="5" cellspacing="0" border="0">
            <tr>
                ##headers##
            </tr>
            ##content##
            </table>
            <p>&copy; Thin 1996 - ' . date('Y') . ' </p>
        </body>
        </html>';
            $tplHeader = '<th>##value##</th>';
            $tplData = '<td>##value##</td>';

            $headers = array();

            foreach ($fields as $field => $fieldInfos) {
                if (!ake('notExportable', $fieldInfos)) {
                    $label = (ake('label', $fieldInfos)) ? $fieldInfos['label'] : ucfirst(\Thin\Inflector::lower($field));
                    $headers[] = \Thin\Html\Helper::display($label);
                }
            }
            $pdfHeader = '';
            foreach ($headers as $header) {
                $pdfHeader .= repl('##value##', $header, $tplHeader);
            }
            $pdf = repl('##headers##', $pdfHeader, $pdf);

            $pdfContent = '';
            foreach ($data as $item) {
                $pdfContent .= '<tr>';
                foreach ($fields as $field => $fieldInfos) {
                    if (!ake('notExportable', $fieldInfos)) {
                        $value = $item->$field;
                        if (ake('contentList', $fieldInfos)) {
                            list($f, $e, $v) = $fieldInfos['contentList'];
                            $value = static::$f($item->$field, $e, $v);
                        }
                        if (empty($value)) {
                            $value = '&nbsp;';
                        }
                        if (ake('type', $fieldInfos)) {
                            if ('image' == $fieldInfos['type']) {
                                $pdfContent .= repl('##value##', '<img src="' . \Thin\Html\Helper::display($value) . '" style="width: 100px;" />', $tplData);
                            } else {
                                $pdfContent .= repl('##value##', \Thin\Html\Helper::display($value), $tplData);
                            }
                        } else {
                            $pdfContent .= repl('##value##', \Thin\Html\Helper::display($value), $tplData);
                        }
                    }
                }
                $pdfContent .= '</tr>';
            }

            $pdf = repl('##content##', $pdfContent, $pdf);
            return \Thin\Pdf::make($pdf, "extraction_" . $type . "_" . date('d_m_Y_H_i_s'), false);
        }

        public static function exportCsv($data, $type)
        {
            $settings       = \Thin\Data::$_settings[$type];
            $fields         = \Thin\Data::$_fields[$type];

            $csv = '';

            foreach ($fields as $field => $fieldInfos) {
                if (!ake('notExportable', $fieldInfos)) {
                    $label = (ake('label', $fieldInfos)) ? $fieldInfos['label'] : ucfirst(\Thin\Inflector::lower($field));
                    $csv .= \Thin\Html\Helper::display($label) . ';';
                }
            }

            $csv = substr($csv, 0, -1);

            foreach ($data as $item) {
                $csv .= "\n";
                foreach ($fields as $field => $fieldInfos) {
                    if (!ake('notExportable', $fieldInfos)) {
                        $value = $item->$field;
                        if (ake('contentList', $fieldInfos)) {
                            list($f, $e, $v) = $fieldInfos['contentList'];
                            $value = static::$f($item->$field, $e, $v);
                        }
                        if (empty($value)) {
                            $value = '';
                        }
                        $csv .= \Thin\Html\Helper::display($value) . ';';
                    }
                }
                $csv = substr($csv, 0, -1);
            }

            if (true === \Thin\Utils::isUtf8($csv)) {
                $csv = utf8_decode($csv);
            }

            header("Content-type: application/excel");
            header('Content-disposition: attachement; filename="extraction_' . $type . '_' . date('d_m_Y_H_i_s') . '.csv"');
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            die($csv);
        }

        public static function exportExcel($data, $type)
        {
            $settings       = \Thin\Data::$_settings[$type];
            $fields         = \Thin\Data::$_fields[$type];

            $excel = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="ProgId" content="Excel.Sheet">
            <meta name="Generator" content="Microsoft Excel 11">
            <style id="Classeur1_17373_Styles">
            <!--table
                {mso-displayed-decimal-separator:"\,";
                mso-displayed-thousand-separator:" ";}
            .xl1517373
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:windowtext;
                font-size:10.0pt;
                font-weight:400;
                font-style:normal;
                text-decoration:none;
                font-family:Arial;
                mso-generic-font-family:auto;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:general;
                vertical-align:bottom;
                mso-background-source:auto;
                mso-pattern:auto;
                white-space:nowrap;}
            .xl2217373
                {padding-top:1px;
                padding-right:1px;
                padding-left:1px;
                mso-ignore:padding;
                color:#FFFF99;
                font-size:10.0pt;
                font-weight:700;
                font-style:normal;
                text-decoration:none;
                font-family:Arial, sans-serif;
                mso-font-charset:0;
                mso-number-format:General;
                text-align:center;
                vertical-align:bottom;
                background:#003366;
                mso-pattern:auto none;
                white-space:nowrap;}
            -->
            </style>
        </head>

            <body>
            <!--[if !excel]>&nbsp;&nbsp;<![endif]-->

            <div id="Classeur1_17373" align="center" x:publishsource="Excel">

            <table x:str border="0" cellpadding="0" cellspacing="0" width=640 style="border-collapse:
             collapse; table-layout: fixed; width: 480pt">
             <col width="80" span=8 style="width: 60pt">
             <tr height="17" style="height:12.75pt">
              ##headers##
             </tr>
             ##content##
            </table>
            </div>
        </body>
    </html>';
            $tplHeader = '<td class="xl2217373">##value##</td>';
            $tplData = '<td>##value##</td>';

            $headers = array();

            foreach ($fields as $field => $fieldInfos) {
                if (!ake('notExportable', $fieldInfos)) {
                    $label = (ake('label', $fieldInfos)) ? $fieldInfos['label'] : ucfirst(\Thin\Inflector::lower($field));
                    $headers[] = \Thin\Html\Helper::display($label);
                }
            }
            $xlsHeader = '';
            foreach ($headers as $header) {
                $xlsHeader .= repl('##value##', $header, $tplHeader);
            }
            $excel = repl('##headers##', $xlsHeader, $excel);

            $xlsContent = '';
            foreach ($data as $item) {
                $xlsContent .= '<tr>';
                foreach ($fields as $field => $fieldInfos) {
                    if (!ake('notExportable', $fieldInfos)) {
                        $value = $item->$field;
                        if (ake('contentList', $fieldInfos)) {
                            list($f, $e, $v) = $fieldInfos['contentList'];
                            $value = static::$f($item->$field, $e, $v);
                        }
                        if (empty($value)) {
                            $value = '&nbsp;';
                        }
                        $xlsContent .= repl('##value##', \Thin\Html\Helper::display($value), $tplData);
                    }
                }
                $xlsContent .= '</tr>';
            }

            $excel = repl('##content##', $xlsContent, $excel);


            $redirect = URLSITE . 'file.php?type=xls&name=' . ('extraction_' . $type . '_' . date('d_m_Y_H_i_s') . '.xls') . '&file=' . md5($excel);
            $cache = CACHE_PATH . DS . md5($excel) . '.xls';
            file_put_contents($cache, $excel);
            \Thin\Utils::go($redirect);
        }

        public static function exportJson($data, $type)
        {
            $settings       = \Thin\Data::$_settings[$type];
            $fields         = \Thin\Data::$_fields[$type];

            $array = array();

            $i = 0;

            foreach ($data as $item) {
                foreach ($fields as $field => $fieldInfos) {
                    $label = (ake('label', $fieldInfos)) ? $fieldInfos['label'] : ucfirst(\Thin\Inflector::lower($field));
                    if (!ake('notExportable', $fieldInfos)) {
                        $value = $item->$field;
                        if (ake('contentList', $fieldInfos)) {
                            list($f, $e, $v) = $fieldInfos['contentList'];
                            $value = static::$f($item->$field, $e, $v);
                        }
                        if (empty($value)) {
                            $value = null;
                        }
                        $array[$i][$label] = \Thin\Html\Helper::display($value);
                    }
                }
                $i++;
            }

            $json = json_encode($array);
            header('Content-disposition: attachment; filename=extraction_' . $type . '_' . date('d_m_Y_H_i_s') . '.json');
            header('Content-type: application/json');
            \Thin\Html\Render::json($json);
            exit;
        }

        public static function getValueEntity($id, $entity, $fields)
        {
            $return = '';
            $item = \Thin\Data::getById($entity, $id);
            if (null === $item) {
                return $return;
            }
            $fields = explode(',', $fields);
            foreach ($fields as $field) {
                $return .= $item->$field . ' ';
            }
            return substr($return, 0, -1);
        }

        public static function getValueVocabulary($id, array $data, array $config = array())
        {
            foreach ($data as $key => $value) {
                if ($id == $key) {
                    return $value;
                }
            }
            return '';
        }
    }
