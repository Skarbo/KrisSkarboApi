<?php

class AbstractCssResource extends ClassCore
{

    // VARIABLES


    protected static $ROOT_FOLDER = "css";
    protected static $API_FOLDER = "api";

    private static $GUI;

    private $jqueryMobileApiFile = "jquery.mobile-1.1.0.min.css";
    private $transitionsApiFile = "transition.min.css";

    private $table = "table";
    private $tableCell = "cell";
    private $tableRow = "row";
    private $tableCellFill = "fill";

    private $right = "right";
    private $center = "center";
    private $top = "top";

    private $italic = "italic";
    private $gray = "gray";

    private $nopadding = "nopadding";
    private $hint = "hint";
    private $hide = "hide";
    private $touch = "touch";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        $this->jqueryMobileApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$API_FOLDER,
                $this->jqueryMobileApiFile );
        $this->transitionsApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$API_FOLDER,
                $this->transitionsApiFile );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return GuiCssResource
     */
    public function gui()
    {
        self::$GUI = self::$GUI ? self::$GUI : new GuiCssResource();
        return self::$GUI;
    }

    // /FUNCTIONS


    public function getTable()
    {
        return $this->table;
    }

    public function getTableCell()
    {
        return $this->tableCell;
    }

    public function getTableRow()
    {
        return $this->tableRow;
    }

    public function getTableCellFill()
    {
        return $this->tableCellFill;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function getCenter()
    {
        return $this->center;
    }

    public function getTop()
    {
        return $this->top;
    }

    public function getItalic()
    {
        return $this->italic;
    }

    public function getGray()
    {
        return $this->gray;
    }

    public function getNopadding()
    {
        return $this->nopadding;
    }

    public function getTransitionsApiFile()
    {
        return $this->transitionsApiFile;
    }

    public function getHint()
    {
        return $this->hint;
    }

    public function getJqueryMobileApiFile()
    {
        return $this->jqueryMobileApiFile;
    }

    public function getHide()
    {
        return $this->hide;
    }

    public function getTouch()
    {
        return $this->touch;
    }

}

?>