<?php

/**
 * 站点元信息服务类
 * 用于组织和管理网站的基础元信息
 */
class SiteMetaService
{
    /**
     * 站点元数据配置
     * @var array
     */
    private $metaConfig;

    /**
     * 默认描述模板
     * @var string
     */
    private $descriptionTemplate;

    /**
     * 构造函数，初始化元信息配置
     */
    public function __construct()
    {
        $this->metaConfig = [
            'site_name' => '体彩网',
            'site_url'  => 'https://cn-zh-sportslottery.com',
            'language'  => 'zh-CN',
            'charset'   => 'UTF-8',
            'keywords'  => ['体育彩票', '彩票资讯', '体彩网', '开奖信息'],
            'description' => '专业的体育彩票信息平台，提供最新彩票资讯与数据分析',
            'author'    => '体彩网团队',
            'version'   => '1.0.0',
        ];

        $this->descriptionTemplate = '%s - %s | %s';
    }

    /**
     * 获取站点元数据
     *
     * @param string|null $key 要获取的键，null表示返回全部
     * @return mixed
     */
    public function getMeta($key = null)
    {
        if ($key === null) {
            return $this->metaConfig;
        }

        return isset($this->metaConfig[$key]) ? $this->metaConfig[$key] : null;
    }

    /**
     * 设置站点元数据
     *
     * @param string $key 键名
     * @param mixed  $value 值
     * @return self
     */
    public function setMeta($key, $value)
    {
        $this->metaConfig[$key] = $value;
        return $this;
    }

    /**
     * 生成简短描述文本
     * 使用模板将站点名称、描述和关键词组合成一段文字
     *
     * @return string HTML安全的描述文本
     */
    public function generateDescription()
    {
        $siteName    = htmlspecialchars($this->metaConfig['site_name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($this->metaConfig['description'], ENT_QUOTES, 'UTF-8');
        $keywordStr  = htmlspecialchars(
            implode('、', $this->metaConfig['keywords']),
            ENT_QUOTES,
            'UTF-8'
        );

        return sprintf($this->descriptionTemplate, $siteName, $description, $keywordStr);
    }

    /**
     * 导出为关联数组，可用于JSON序列化
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'        => $this->metaConfig['site_name'],
            'url'         => $this->metaConfig['site_url'],
            'language'    => $this->metaConfig['language'],
            'keywords'    => implode(', ', $this->metaConfig['keywords']),
            'description' => $this->generateDescription(),
            'author'      => $this->metaConfig['author'],
            'version'     => $this->metaConfig['version'],
        ];
    }

    /**
     * 输出标准HTML meta标签
     *
     * @return void 直接输出HTML
     */
    public function renderMetaTags()
    {
        $charset = htmlspecialchars($this->metaConfig['charset'], ENT_QUOTES, 'UTF-8');
        $desc    = htmlspecialchars($this->generateDescription(), ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars(
            implode(', ', $this->metaConfig['keywords']),
            ENT_QUOTES,
            'UTF-8'
        );

        echo '<meta charset="' . $charset . '">' . "\n";
        echo '<meta name="description" content="' . $desc . '">' . "\n";
        echo '<meta name="keywords" content="' . $keywords . '">' . "\n";
    }
}

// ----- 使用示例 -----
$metaService = new SiteMetaService();

// 获取完整配置
$fullConfig = $metaService->getMeta();
echo "站点名称: " . htmlspecialchars($fullConfig['site_name'], ENT_QUOTES, 'UTF-8') . "\n";
echo "站点URL: " . htmlspecialchars($fullConfig['site_url'], ENT_QUOTES, 'UTF-8') . "\n";

// 生成描述文本
echo "描述: " . $metaService->generateDescription() . "\n";

// 修改元数据并查看变化
$metaService->setMeta('site_name', '体彩网（新版）');
echo "更新后描述: " . $metaService->generateDescription() . "\n";

// 导出为数组
$exportData = $metaService->toArray();
echo "JSON: " . json_encode($exportData, JSON_UNESCAPED_UNICODE) . "\n";

// 渲染HTML meta标签（示例不实际输出，仅展示调用方式）
// $metaService->renderMetaTags();