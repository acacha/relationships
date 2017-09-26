<?php

namespace Acacha\Relationships\Wrappers;

use Maatwebsite\Excel\Files\ExcelFile;
use Illuminate\Foundation\Application;
use Maatwebsite\Excel\Excel;

/**
 * Class CodigosPostalesListImport.
 */
class CodigosPostalesListImport extends ExcelFile
{

    protected $file1;

    /**
     * @param Application $app
     * @param Excel       $excel
     * @param String      $file
     */
    public function __construct(Application $app, Excel $excel,$file)
    {
        $this->file1 = $file;
        parent::__construct($app, $excel);
        $this->file = $this->loadFile();
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file1;
    }

    /**
     * @var null
     */
//    protected $encoding = 'ISO-8859-1';

    /**
     * @var string
     */
    protected $delimiter  = ':';

    /**
     * @var string
     */
    protected $enclosure  = '';

    /**
     * @var string
     */
    protected $lineEnding = '\r\n';

}