<?php

class HTML { 

    public $children;
    public $attributes;
    public $tag_name;
    public $single_tag;
    public $content;
    
    public function __construct( $tag_name = 'html', $single_tag = false ) {
        $this->tag_name = $tag_name;
        $this->single_tag = $single_tag;
    }
    
    public function SetAttribute( $name = '', $value = '' ) {
        if( isset( $name ) ) {
            $this->attributes[$name] = $value;
        }
    }
    
    public function SetContent( $content = '' ) {
        if( isset( $content ) ) {
            $this->content = $content;
        }
    }
    
    public function AddContent( $content = '' ) {
        if( isset( $content ) ) {
            $this->content .= $content;
        }
    }
    
    public function AddChild( HTML $child ) {
        $this->children[] = $child;
    }

    public function Display( $depth = 0 ) {
        $depth++;
        $return_string = '<';
        $return_string .= $this->tag_name;
        if( is_array( $this->attributes ) ) {
            foreach( $this->attributes as $name => $value ) {
                $return_string .= ' '.$name.'="'.$value.'"';
            }
        }
        if( $this->single_tag ) {
            $return_string .= ' />'."\n";
        }
        else {
            $return_string .= '>';
            $return_string .= $this->content;
            if( is_array( $this->children ) ) {
                $return_string .= "\n";
                foreach( $this->children as $child ) {
                    for( $i = 0; $i < $depth; $i++ ) {
                        $return_string .= "    ";
                    }
                    $return_string .= $child->Display( $depth );
                }
            }
            if( $this->content == '' || sizeof( $this->children ) > 0 ) {            //  We don't want to be adding indentation spaces to the content between two tags
                for( $i = 1; $i < $depth; $i++ ) {
                    $return_string .= "    ";
                }            
            }
            $return_string .= '</'.$this->tag_name.'>'."\n";
        }
        return $return_string;
    }
    
    public function __toString() {
        $this->Display();
    }
    
    public function AddBr() {
        $br = new HTML( 'br', true );
        $this->AddChild( $br );
    }
}

?>
