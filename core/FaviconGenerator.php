<?php
/**
 * Favicon生成器 - 文字转图标
 * 支持单字/双字生成漂亮的背景文字图标
 */
class FaviconGenerator {
    
    /**
     * 预设配色方案
     */
    private static $colorSchemes = [
        'blue' => [
            'bg' => [59, 130, 246],      // 蓝色背景
            'text' => [255, 255, 255],   // 白字
        ],
        'purple' => [
            'bg' => [147, 51, 234],      // 紫色
            'text' => [255, 255, 255],
        ],
        'green' => [
            'bg' => [34, 197, 94],       // 绿色
            'text' => [255, 255, 255],
        ],
        'orange' => [
            'bg' => [249, 115, 22],      // 橙色
            'text' => [255, 255, 255],
        ],
        'red' => [
            'bg' => [239, 68, 68],       // 红色
            'text' => [255, 255, 255],
        ],
        'teal' => [
            'bg' => [20, 184, 166],      // 青色
            'text' => [255, 255, 255],
        ],
        'pink' => [
            'bg' => [236, 72, 153],      // 粉色
            'text' => [255, 255, 255],
        ],
        'dark' => [
            'bg' => [30, 30, 30],        // 深色
            'text' => [255, 255, 255],
        ],
    ];
    
    /**
     * 生成favicon
     * @param string $text 文字（1-2个字符最佳）
     * @param string $colorScheme 配色方案
     * @param int $size 尺寸（默认32x32）
     * @return string PNG二进制数据
     */
    public static function generate(string $text, string $colorScheme = 'blue', int $size = 32): string {
        // 检查GD库
        if (!function_exists('imagecreatetruecolor')) {
            throw new Exception('PHP GD库未安装');
        }
        
        // 获取配色
        $scheme = self::$colorSchemes[$colorScheme] ?? self::$colorSchemes['blue'];
        
        // 创建图像
        $img = imagecreatetruecolor($size, $size);
        
        // 启用抗锯齿
        imageantialias($img, true);
        
        // 分配颜色
        $bgColor = imagecolorallocate($img, $scheme['bg'][0], $scheme['bg'][1], $scheme['bg'][2]);
        $textColor = imagecolorallocate($img, $scheme['text'][0], $scheme['text'][1], $scheme['text'][2]);
        
        // 填充背景（圆角效果）
        imagefill($img, 0, 0, $bgColor);
        
        // 绘制圆角矩形（简化版，直接用背景色填充）
        // 如果需要更精细的圆角，可以用imagesetpixel逐像素绘制
        
        // 处理文字
        $text = mb_substr(trim($text), 0, 2, 'UTF-8'); // 最多2个字
        $textLen = mb_strlen($text, 'UTF-8');
        
        // 字体大小
        $fontSize = $textLen === 1 ? $size * 0.65 : $size * 0.45;
        
        // 查找字体文件
        $fontFile = self::findFont();
        
        // 计算文字位置（居中）
        if ($fontFile) {
            // 使用TrueType字体
            $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);
            $textWidth = $bbox[2] - $bbox[0];
            $textHeight = $bbox[1] - $bbox[7];
            $x = ($size - $textWidth) / 2 - $bbox[0];
            $y = ($size - $textHeight) / 2 + $textHeight;
            
            imagettftext($img, $fontSize, 0, (int)$x, (int)$y, $textColor, $fontFile, $text);
        } else {
            // 使用内置字体
            $font = 5; // 内置最大字体
            $textWidth = imagefontwidth($font) * strlen($text);
            $textHeight = imagefontheight($font);
            $x = ($size - $textWidth) / 2;
            $y = ($size - $textHeight) / 2;
            
            imagestring($img, $font, (int)$x, (int)$y, $text, $textColor);
        }
        
        // 输出PNG
        ob_start();
        imagepng($img, null, 9); // 最高压缩
        $data = ob_get_clean();
        // PHP 8.0+ imagedestroy无效果，PHP 8.5+ 废弃，保留兼容性
        if (PHP_VERSION_ID < 80000) {
            imagedestroy($img);
        }
        
        return $data;
    }
    
    /**
     * 查找可用的中文字体
     */
    private static function findFont(): ?string {
        // 优先使用网站目录下的字体（绕过open_basedir限制）
        $webFonts = [
            ROOT_PATH . '/assets/fonts/DroidSansFallbackFull.ttf',
            ROOT_PATH . '/assets/fonts/wqy-zenhei.ttc',
        ];
        foreach ($webFonts as $font) {
            if (file_exists($font)) {
                return $font;
            }
        }
        
        // 系统字体路径（可能在open_basedir限制下无法访问）
        $fonts = [
            '/usr/share/fonts/truetype/droid/DroidSansFallbackFull.ttf', // Debian Droid（中文）
            '/usr/share/fonts/truetype/wqy/wqy-zenhei.ttc',           // WenQuanYi
            '/usr/share/fonts/truetype/wqy/wqy-microhei.ttc',
            '/usr/share/fonts/opentype/noto/NotoSansCJK-Regular.ttc', // Noto
            '/usr/share/fonts/truetype/noto/NotoSansCJK-Regular.ttc',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',        // Debian
            '/usr/share/fonts/TTF/DejaVuSans.ttf',
            '/System/Library/Fonts/PingFang.ttc',                      // macOS
            '/System/Library/Fonts/STHeiti Light.ttc',
            'C:/Windows/Fonts/msyh.ttc',                               // Windows 微软雅黑
            'C:/Windows/Fonts/simhei.ttf',
        ];
        
        foreach ($fonts as $font) {
            if (file_exists($font)) {
                return $font;
            }
        }
        
        return null;
    }
    
    /**
     * 获取所有配色方案
     */
    public static function getColorSchemes(): array {
        return array_keys(self::$colorSchemes);
    }
    
    /**
     * 生成并保存favicon文件
     * @return string 保存的相对路径
     */
    public static function save(string $text, string $colorScheme, string $saveDir): string {
        // 生成32x32 favicon
        $png32 = self::generate($text, $colorScheme, 32);
        
        // 生成16x16版本
        $png16 = self::generate($text, $colorScheme, 16);
        
        // 确保目录存在
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }
        
        // 保存文件
        $filename = 'favicon_' . time() . '.png';
        file_put_contents($saveDir . '/' . $filename, $png32);
        
        // 同时保存16x16版本
        file_put_contents($saveDir . '/favicon_16_' . time() . '.png', $png16);
        
        return '/assets/images/' . $filename;
    }
}
