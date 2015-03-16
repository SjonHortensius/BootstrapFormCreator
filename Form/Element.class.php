<?php
/*
	Element.class.php

	Copyright (C) 2015 Sjon Hortensius
	All rights reserved.

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:

	1. Redistributions of source code must retain the above copyright notice,
	   this list of conditions and the following disclaimer.

	2. Redistributions in binary form must reproduce the above copyright
	   notice, this list of conditions and the following disclaimer in the
	   documentation and/or other materials provided with the distribution.

	THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
	INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
	AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
	AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
	OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
	SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
	INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
	CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
	ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
	POSSIBILITY OF SUCH DAMAGE.
*/

class Form_Element
{
	protected $_attributes = array('class' => array());
	protected $_parent;

	public function addClass()
	{
		foreach (func_get_args() as $class) {
			$this->_attributes['class'][$class] = true;
		}

		return $this;
	}

	public function removeClass($class)
	{
		unset($this->_attributes['class'][$class]);

		return $this;
	}

	public function getClasses()
	{
		return implode(' ', array_keys($this->getAttribute('class')));
	}

	public function setAttribute($key, $value = null)
	{
		$this->_attributes[$key] = $value;

		return $this;
	}

	public function getAttribute($name)
	{
		return $this->_attributes[$name];
	}

	public function removeAttribute($name)
	{
		unset($this->_attributes[$name]);

		return $this;
	}

	public function getHtmlAttribute()
	{
		/* Will overwright _attributes['class'] with string Therefore you cannot 
		 * delete or add classes once getHtmlAttribute() has been called. */
		if (empty($this->_attributes['class'])) {
			$this->removeAttribute('class');
		} else {
			$this->_attributes['class'] = $this->getClasses();
		}

		$attributes = '';
		foreach ($this->_attributes as $key => $value) {
			$attributes .= ' ' . $key . (isset($value) ? '="' . htmlspecialchars($value) . '"' : '');
		}

		return $attributes;
	}

	protected function _setParent(Form_Element $parent)
	{
		$this->_parent = $parent;
	}
}
