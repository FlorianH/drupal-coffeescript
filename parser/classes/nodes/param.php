<?php

namespace CoffeeScript;

class yy_Param extends yy_Base
{
  public $children = array('name', 'value');

  function constructor($name = NULL, $value = NULL, $splat = NULL)
  {
    $this->name = $name;
    $this->value = $value;
    $this->splat = $splat;

    return $this;
  }

  function as_reference($options)
  {
    if ($this->reference)
    {
      return $this->reference;
    }

    $node = $this->name;

    if ($node->this)
    {
      $node = $node->properties[0]->name;

      if ($node->value->reserved)
      {
        $node = yy('Literal', '_'.$node->value);
      }
    }
    else if ($node->is_complex())
    {
      $node = yy('Literal', $options['scope']->free_variable('arg'));
    }

    $node = yy('Value', $node);

    if ($this->splat)
    {
      $node = yy('Splat', $node);
    }

    return ($this->reference = $node);
  }

  function compile($options=NULL, $level = NULL)
  {
    return $this->name->compile($options, LEVEL_LIST);
  }

  function is_complex()
  {
    return $this->name->is_complex();
  }
}

?>
