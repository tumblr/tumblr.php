<?php

namespace Tumblr\API;

abstract class HashInitializable 
{
    public function __construct($args) 
    {
        foreach($args as $name => $value)
        {
            if(property_exists($this, $name))
            {
                $this->{$name} = $value;
            }
        }
    }
}