<?php
/**
 * CompileClass.php
 *
 * PhpStorm
 *
 * @author: xielin
 */
namespace Library\Mvc\TemplateImpl;

/**
 * Class CompileClass
 *
 * @package Library\Mvc\TemplateImpl
 */
class CompileClass
{
	/** @var string  待编译的文件 */
	private $template;

	/** @var string  需要替换的文本 */
	private $content;

	/** @var string 编译后的文件 */
	private $compiledFile;

	/** @var string 左界定符 */
	private $left = '{';

	/** @var string 右界定符 */
	private $right = '}';

	/** @var array 值栈 */
	private $values = [];

	/** @var array 模板正则 */
	private $T_P = [];

	/** @var array PHP正则 */
	private $T_R = [];

	/**
	 *
	 */
	function __construct()
	{
		$this->T_P[] = '#\{\\$(.*?)\}#';
		/*
		$this->T_P[] = '#\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z_\x7f-\xff]*)\}#';
		$this->T_P[] = '#\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z_\x7f-\xff]*)\\.([a-zA-Z_\x7f-\xff][a-zA-Z_\x7f-\xff]*)\}#';	//输出数组中某个索引
		*/
		$this->T_P[] = '#\{(loop|foreach)\s+\\$([a-zA-Z_\x7f-\xff][a-zA-Z_\x7f-\xff]*)\}#';
		$this->T_P[] = '#\{\/(loop|foreach)}#';
		$this->T_P[] = '#\{if(.*?)\}#';
		$this->T_P[] = '#\{elseif(.*?)\}#';
		$this->T_P[] = '#\{else\}#';
		$this->T_P[] = '#\{\/if\}#';

		$this->T_R[] = "<?php echo \$\\1; ?>";
		/*
		$this->T_R[] = "<?php echo \$\\1; ?>";
		$this->T_R[] = "<?php echo \$\\1['\\2']; ?>";
		*/
		$this->T_R[] = "<?php foreach ((array) \$\\2 as \$k=>\$v){ ?>";
		$this->T_R[] = "<?php } ?>";
		$this->T_R[] = "<?php if (\\1) { ?>";
		$this->T_R[] = "<?php elseif (\\1) { ?>";
		$this->T_R[] = "<?php } else { ?>";
		$this->T_R[] = "<?php } ?>";

	}


	/**
	 * @param $source
	 * @param $destination
	 */
	public function compile($source, $destination)
	{
		$this->content = file_get_contents($source);
		$this->content = preg_replace($this->T_P, $this->T_R, $this->content);
		file_put_contents($destination, $this->content);
	}

	/**
	 * @return array
	 */
	public function getValues()
	{
		return $this->values;
	}

	/**
	 * @param array $values
	 */
	public function setValues($values)
	{
		$this->values = $values;
	}


}