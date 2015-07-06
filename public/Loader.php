<?php
/**
 * Loader.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library;


/**
 * Class Loader
 *
 * @package Library
 */
class Loader
{
    /** @var array 带有命名空间的目录  ['namespace' => $directory] */
    private static $_namespaceClasses;

    /** @var array 不带有命名空间的目录 [$directory1, $directory2] */
    private static $_classes;

    /** @var  array 引入第三方类文件  todo */
    private static $_autoloadClasses;

    /**
     * 加入默认的命名空间对应的目录,用于自动加载文件
     */
    function __construct()
    {
        self::$_namespaceClasses = [];
        self::$_classes = [];
    }


    /**
     * 自定义的自动加载函数
     *
     * @param $className
     * @throws \Exception
     */
    public static function autoload($className)
    {
        $file_exists = false;
        $filePath = '';
        if (strpos($className, '\\') !== false) {   //说明类带有命名空间
            foreach (self::$_namespaceClasses as $namespace => $directory) {
                if (strpos($className, $namespace) !== false) {
                    //找到命名空间对应的目录路径,将命名空间的一部分替换成目录路径(命名空间的除去定义的命名空间对应指定的目录外,其他多余的命名空间与目录对应(包括大小写))
                    $relativeNamespacePath = str_replace($namespace, $directory, str_replace('\\', DIRECTORY_SEPARATOR, $className)) . '.php';
                    if (file_exists($relativeNamespacePath)) {
                        $file_exists = true;
                        $filePath = $relativeNamespacePath;
                        break;
                    }

                }
            }
        } else {    //类不带有命名空间
            $relativePath = DIRECTORY_SEPARATOR . $className . '.php';
            foreach (self::$_classes as $class) {
                if (file_exists($class . $relativePath)) {
                    $file_exists = true;
                    $filePath = $class . $relativePath;
                    break;
                }
            }
        }

        if (!$file_exists) {
            throw new \InvalidArgumentException("can not find class {$className}");
        }
        require_once $filePath;
    }


    /**
     * 注册命名空间目录
     * eg : $loader->registerNamespace([
     *      'Library' => '../library',
     *      'Controller' => '../controller',
     * ])
     * @param array $namespaces
     */
    public function registerNamespace(array $namespaces)
    {
        self::$_namespaceClasses += $namespaces;
    }


    /**
     * 注册非命名空间目录
     *
     * @param array $directories
     */
    public function registerDir(array $directories)
    {
        self::$_classes += $directories;
    }

    /**
     * 加载某个目录下的所有PHP文件
     *
     * @param $directory
     */
    private function loadClasses($directory)
    {
        $files = [];
        if ($handle = opendir($directory)) {
            while ( ($file = readdir($handle)) !== false ) {
                if ($file !== '.' && $file !== '..') {  //去除当前目录和上一级目录
                    if (is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
                        $this->loadClasses($directory . DIRECTORY_SEPARATOR . $file);
                    } else {
                        $files[] = $directory . DIRECTORY_SEPARATOR . $file;
                    }
                }
            }
            closedir($handle);
        }
        foreach ($files as $includeFileOrDirectory) {
            //目录就不处理了,递归里面已经包含了
            if (is_string($includeFileOrDirectory) && $this->getFileExtension($includeFileOrDirectory) == 'php') {
                include $includeFileOrDirectory;
            }
        }
    }


    /**
     * 获取文件后缀名
     *
     * @param $includeFileOrDirectory
     * @return string
     */
    private function getFileExtension($includeFileOrDirectory)
    {
        if (($extension = strrchr($includeFileOrDirectory, '.')) !== false) {
            return ltrim($extension, '.');
        }
        return '';
    }

}

spl_autoload_register(['\Library\Loader', 'autoload']);



