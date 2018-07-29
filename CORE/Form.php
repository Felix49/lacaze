<?php

class Form{

	private $html;
	public $rows = array();
	private $method = 'post';
	private $action;
	private $class = '';
	private $enctype;
	private $errors = '';
	private $shapes = [
		'initial' => ['',''],
		'line' => ['<div class="line">','</div>'],
		'line-center' => ['<div class="line center">','</div>'],
		'line-editable' => ['<div class="line editable">','</div>'],
		'line-double-editable' => ['<div class="line-double editable">','</div>'],
		'line-double' => ['<div class="line-double">','</div>'],
		'line-begin' => ['<div class="line">',''],
		'line-end' => ['','</div>'],
		'inline' => ['<div class="inline">','</div>'],
		'textarea' => ['<div class="line textarea">','<div class="clear"></div></div>'],
	];
	private $basis_options = [
		'type' 			=> 'text',
		'label' 		=> false,
		'id' 			=> null,
		'value' 		=> null,
		'name' 			=> null,
		'class' 		=> null,
		'placeholder' 	=> null,
		'cols' 			=> 7,
		'rows' 			=> 5,
		'input-shape'	=> 'initial',
		'clearBefore'	=> false,
		'clearAfter'	=> false,
		'title'			=> '',
		'rough'			=> false,
		'content'		=> '',
		'checked'		=> false,
	];
	
	function __construct($method = '', $action = '',$enctype = null){
		$this->method = $method;
		$this->action = $action;
		$this->enctype = $enctype;
	}

	public function render($man = null){

		if(!isset($man)){

			$this->html .= '<form class="'.$this->class.'" method="'.$this->method.'" action="'.$this->action.'" enctype="'.$this->enctype.'">';
			
			// On boucle pour chaque input
			foreach ($this->rows as $name => $row) {

				// possibilité de mettre un clear avant
				if($row['clearBefore']) $this->html .= '<div class="clear"></div>';

				//Style de l'input : balise ouvrante
				$this->rowShape0($row['input-shape']);

				$gbsel = false;

				if(isset($_SESSION['giveback'][$row['name']])){
					if($row['type'] == 'checkbox') $row['checked'] = true;
					$value = $_SESSION['giveback'][$row['name']];
					$gbvalue = $_SESSION['giveback'][$row['name']];
				}else{
					$value = $row['value'];
					$gbvalue = false;
				}

				// Element neutre à insérer brut
				if($row['rough']){
					$this->html .= $row['content'];
					continue;
				}

				if(isset($_SESSION['errors'][$row['name']])) $row['class'] .= ' input-error';
				
				//si label doit etre affiché
				if($row['label'] && $row['type'] != 'submit'){ 
					$this->html .= '<label title="'.$row['title'].'" class="'.$row['class'].'" for="'.$row['id'].'">'.$row['label'].'</label>';
				}
				// input fonction du type
				if($row['type'] == 'textarea'){
					$this->html .= '<textarea title="'.$row['title'].'" class="'.$row['class'].'" cols="'.$row['cols'].'" rows="'.$row['rows'].'"  id="'.$row['id'].'" name="'.$row['name'].'" placeholder="'.$row['placeholder'].'">'.$value.'</textarea>';
				//plugin trombowyg
				}elseif($row['type'] == 'trumbowyg' ) {
					$this->html .= '<div id="trumbowyg">' . $row['value'] . '</div>';
				}elseif($row['type'] == 'trumbowyg2' ){
					$this->html .= '<div id="trumbowyg2"">'.$row['value'].'</div>';
				}elseif($row['type'] == 'dropimage'){
					$this->html .= '<div title="'.$row['title'].'" class="dropimage"></div>';
				}elseif($row['type'] == 'select'){
					$this->html .= '<select title="'.$row['title'].'" class="'.$row['class'].'" name="'.$row['name'].'" id="'.$row['id'].'">';
					foreach ($row['option'] as $opt) {
						//option selected ou non~~
						$selected = (isset($opt['selected']) || ($opt['value'] == $gbvalue)) ? 'selected' : '';
						$this->html .= '<option value="'.$opt['value'].'" '.$selected.'>'.$opt['text'].'</option>';
					}
					$this->html .= '</select>';
				}else{
					// Checkbox checked
					$chk = $row['checked'] ? 'checked' : '' ;
					$this->html .= '<input '.$chk.' title="'.$row['title'].'" class="'.$row['class'].'" id="'.$row['id'].'" type ="'.$row['type'].'" name="'.$row['name'].'" value="'.$value.'" placeholder="'.$row['placeholder'].'"/>';
				}

				//Style de l'input ; balise fermante
				$this->rowShape1($row['input-shape']);

				// possibilité de mettre un clear avant
				if($row['clearAfter']) $this->html .= '<div class="clear"></div>';

			}
				
			$dispSend = true;
			foreach ($this->rows as $value) {
				if($value['type'] == 'submit')
					$dispSend = false;
			}

			$this->setErrors();

			if($dispSend){
				$this->html .= '<button type="submit">Envoyer</button>';
			}
			$this->html .= '</form>';

			//reinitialisation des giveback
			$_SESSION['giveback'] = array();

			echo $this->html;

		}elseif($man == 'man'){

		}
	}

	public function setClass($cl){
		$this->class = $cl;
		return true;
	}

	public function addRow($nom,$param,$cons = [],$after = null){
		// attribut "name" par défaut le nom de l'input
		if(!isset($param['name'])) $param['name'] = $nom;
		$row = array_merge($this->basis_options, $param);
		$row['constraints'] = $cons;
		
		if(isset($after)){
			$r1 = array_slice($this->rows, 0,$after);
			$r2 = array_slice($this->rows, $after);
			$r1[$nom] = $row;
			$this->rows = $r1 + $r2;
		}else{
			$this->rows[$nom] = $row;
		}
	}

	public function removeRow($nom){
		if(isset($this->rows[$nom])) unset($this->rows[$nom]);
	}

	public function setAttribute($nom,$attr){
		if(isset($this->rows[$nom])){
			foreach ($attr as $nam => $att) {
				$this->rows[$nom][$nam] = $att;
			}
		}
	}

	public function setOptionSelected($selectname,$optionvalue){
		if(isset($this->rows[$selectname])){
			if($this->rows[$selectname]['type'] == 'select'){
				foreach ($this->rows[$selectname]['option'] as $key => $value) {
					if($value['value'] == $optionvalue){
						$this->rows[$selectname]['option'][$key]['selected'] = 'selected';
						return true;
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function setConstraint($rowname,$cons){
		$this->rows[$rowname]['constraints'] = $cons;
	}

	public function setMethodAction($m = null,$a = null){
		$this->method = isset($m) ? $m : $this->method;
		$this->action = isset($a) ? $a : $this->action;
	}

	private function setErrors(){
		if(!empty($_SESSION['errors'])){
			$this->html .= '<ul class="errors">';
			foreach ($_SESSION['errors'] as $message) {
				$this->html .= '<li>'.$message.'</li>';
			}
			$this->html .= '</ul>';
		}
	}

	private function rowShape0($sh){
		$this->html .= $this->shapes[$sh][0];
	}

	private function rowShape1($sh){
		$this->html .= $this->shapes[$sh][1];
	}
	
}