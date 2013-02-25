<?php

/**
 * XHTML elements
 *
 * @author Kris
 *
 */
class Xhtml extends ClassCore
{

    static $NBSP = "&nbsp;";
    static $BULL = "&bull;";
    static $RAQUO = "&raquo;";
    static $ENCODING_UTF8 = "UTF-8";
    static $ENCODING_ISO = "iso-8859-1";

    /**
     * @param string $content
     * @param string $href
     * @return AnchorXhtml
     */
    static function a( $content = "", $href = "" )
    {
        return new AnchorXhtml( $content, $href );
    }

    /**
     * @param string $content
     * @return AcronymXhtml
     */
    static function acronym( $content = "" )
    {
        return new AcronymXhtml( $content );
    }

    /**
     * @param string $content
     * @return BodyXhtml
     */
    static function body( $content = "" )
    {
        return new BodyXhtml();
    }

    /**
     * @return BrXhtml
     */
    static function br()
    {
        return new BrXhtml();
    }

    /**
     * @param string $content
     * @return ButtonXhtml
     */
    static function button( $content = "" )
    {
        return new ButtonXhtml( $content );
    }

    /**
     * @param string $content
     * @return DivXhtml
     */
    static function div( $content = "" )
    {
        return new DivXhtml( $content );
    }

    /**
     * @param string $content
     * @return FieldsetXhtml
     */
    static function fieldset( $content = "" )
    {
        return new FieldsetXhtml( $content );
    }

    /**
     * @param string $content
     * @return FormXhtml
     */
    static function form( $content = "" )
    {
        return new FormXhtml( $content );
    }

    /**
     * @param int $size
     * @param string $content
     * @return HeaderXhtml
     */
    static function h( $size, $content = "" )
    {
        return new HeaderXhtml( $size, $content );
    }

    /**
     * @param string $content
     * @return HeadXhtml
     */
    static function head( $content = "" )
    {
        return new HeadXhtml( $content );
    }

    /**
     * @param string $content
     * @return HtmlXhtml
     */
    static function html( $content = "" )
    {
        return new HtmlXhtml( $content );
    }

    /**
     * @return HrXhtml
     */
    static function hr()
    {
        return new HrXhtml();
    }

    /**
     * @param string $content
     * @return ItalicXhtml
     */
    static function italic( $content = "" )
    {
        return new ItalicXhtml( $content );
    }

    /**
     * @return ImgXhtml
     */
    static function img( $src = "", $alt = "" )
    {
        return new ImgXhtml( $src, $alt );
    }

    /**
     * @param string $value
     * @param string $name
     * @return InputXhtml
     */
    static function input( $value = "", $name = "" )
    {
        return new InputXhtml( $value, $name );
    }

    /**
     * @param string $content
     * @return LabelXhtml
     */
    static function label( $content = "" )
    {
        return new LabelXhtml( $content );
    }

    /**
     * @param string $content
     * @return LiXhtml
     */
    static function li( $content = "" )
    {
        return new LiXhtml( $content );
    }

    /**
     * @return LinkXhtml
     */
    static function link()
    {
        return new LinkXhtml();
    }

    /**
     * @param string $content
     * @return LegendXhtml
     */
    static function legend( $content = "" )
    {
        return new LegendXhtml( $content );
    }

    /**
     * @return MetaXhtml
     */
    static function meta()
    {
        return new MetaXhtml();
    }

    /**
     * @param string $content
     * @return OlXhtml
     */
    static function ol( $content = "" )
    {
        return new OlXhtml( $content );
    }

    /**
     * @param string $content
     * @return OptionXhtml
     */
    static function option( $content = "", $value = "" )
    {
        return new OptionXhtml( $content, $value );
    }

    /**
     * @param string $content
     * @return OptgroupXhtml
     */
    static function optgroup( $content = "" )
    {
        return new OptgroupXhtml( $content );
    }

    /**
     * @param string $content
     * @return ParagraphXhtml
     */
    static function p( $content = "" )
    {
        return new ParagraphXhtml( $content );
    }

    /**
     * @param string $content
     * @return PreXhtml
     */
    static function pre( $content = "" )
    {
        return new PreXhtml( $content );
    }

    /**
     * @param string $content
     * @return ScriptXhtml
     */
    static function script( $content = "" )
    {
        return new ScriptXhtml( $content );
    }

    /**
     * @param string $content
     * @return SelectXhtml
     */
    static function select( $content = "" )
    {
        return new SelectXhtml( $content );
    }

    /**
     * @param string $content
     * @return StrongXhtml
     */
    static function strong( $content = "" )
    {
        return new StrongXhtml( $content );
    }

    /**
     * @param string $content
     * @return StyleXhtml
     */
    static function style( $content = "" )
    {
        return new StyleXhtml( $content );
    }

    /**
     * @param string $content
     * @return SpanXhtml
     */
    static function span( $content = "" )
    {
        return new SpanXhtml( $content );
    }

    /**
     * @param string $content
     * @return TableXhtml
     */
    static function table( $content = "" )
    {
        return new TableXhtml( $content );
    }

    /**
     * @param string $content
     * @return TbodyXhtml
     */
    static function tbody( $content = "" )
    {
        return new TbodyXhtml( $content );
    }

    /**
     * @param string $content
     * @return TdXhtml
     */
    static function td( $content = "" )
    {
        return new TdXhtml( $content );
    }

    /**
     * @param string $content
     * @return TextareaXhtml
     */
    static function textarea( $content = "" )
    {
        return new TextareaXhtml( $content );
    }

    /**
     * @param string $content
     * @return TfootXhtml
     */
    static function tfoot( $content = "" )
    {
        return new TfootXhtml( $content );
    }

    /**
     * @param string $content
     * @return ThXhtml
     */
    static function th( $content = "" )
    {
        return new ThXhtml( $content );
    }

    /**
     * @param string $content
     * @return TheadXhtml
     */
    static function thead( $content = "" )
    {
        return new TheadXhtml( $content );
    }

    /**
     * @param string $content
     * @return TitleXhtml
     */
    static function title( $content = "" )
    {
        return new TitleXhtml( $content );
    }

    /**
     * @param string $content
     * @return TrXhtml
     */
    static function tr( $content = "" )
    {
        return new TrXhtml( $content );
    }

    /**
     * @param string $content
     * @return UlXhtml
     */
    static function ul( $content = "" )
    {
        return new UlXhtml( $content );
    }

}

?>