<?php

namespace Kejojedi\Breeze;

class Html
{
    private $start_tag, $end_tag, $content, $attributes = [];

    public function __construct($start_tag = null, $end_tag = null, $content = null, $attributes = [])
    {
        $this->start_tag = $start_tag;
        $this->end_tag = $end_tag;
        $this->content = $content;
        $this->attributes[] = $attributes;
    }

    public function __toString()
    {
        $html = '';

        if ($this->start_tag) {
            $attributes = [];
            $attributes_html = '';

            foreach ($this->attributes as $attribute) {
                foreach ($attribute as $key => $value) {
                    if (isset($attributes[$key])) {
                        $attributes[$key] .= ' ' . $value;
                    }
                    else {
                        $attributes[$key] = $value;
                    }
                }
            }

            foreach ($attributes as $key => $value) {
                $attributes_html .= ' ' . $key . '="' . $value . '"';
            }

            $html .= '<' . $this->start_tag . $attributes_html . '>';
        }

        $html .= $this->content;

        if ($this->end_tag) {
            $html .= '</' . $this->end_tag . '>';
        }

        return $html;
    }

    public function type($type)
    {
        $this->attributes[] = ['type' => $type];
        return $this;
    }

    public function id($id)
    {
        $this->attributes[] = ['id' => $id];
        return $this;
    }

    public function class($class)
    {
        $this->attributes[] = ['class' => $class];
        return $this;
    }

    public function style($style)
    {
        $this->attributes[] = ['style' => $style];
        return $this;
    }

    public function margin($margin)
    {
        $this->attributes[] = ['class' => 'm-' . $margin];
        return $this;
    }

    public function marginTop($margin)
    {
        $this->attributes[] = ['class' => 'mt-' . $margin];
        return $this;
    }

    public function marginBottom($margin)
    {
        $this->attributes[] = ['class' => 'mb-' . $margin];
        return $this;
    }

    public function marginLeft($margin)
    {
        $this->attributes[] = ['class' => 'ml-' . $margin];
        return $this;
    }

    public function marginRight($margin)
    {
        $this->attributes[] = ['class' => 'mr-' . $margin];
        return $this;
    }

    public function marginVertical($margin)
    {
        $this->attributes[] = ['class' => 'my-' . $margin];
        return $this;
    }

    public function marginHorizontal($margin)
    {
        $this->attributes[] = ['class' => 'mx-' . $margin];
        return $this;
    }

    public function padding($padding)
    {
        $this->attributes[] = ['class' => 'p-' . $padding];
        return $this;
    }

    public function paddingTop($padding)
    {
        $this->attributes[] = ['class' => 'pt-' . $padding];
        return $this;
    }

    public function paddingBottom($padding)
    {
        $this->attributes[] = ['class' => 'pb-' . $padding];
        return $this;
    }

    public function paddingLeft($padding)
    {
        $this->attributes[] = ['class' => 'pl-' . $padding];
        return $this;
    }

    public function paddingRight($padding)
    {
        $this->attributes[] = ['class' => 'pr-' . $padding];
        return $this;
    }

    public function paddingVertical($padding)
    {
        $this->attributes[] = ['class' => 'py-' . $padding];
        return $this;
    }

    public function paddingHorizontal($padding)
    {
        $this->attributes[] = ['class' => 'px-' . $padding];
        return $this;
    }
}
