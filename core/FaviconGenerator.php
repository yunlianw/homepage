<?php
/**
 * Favicon生成器 - 文字转图标
 * 支持自定义背景色、字体色（hex颜色代码）
 */
class FaviconGenerator {
    
    /**
     * hex颜色转RGB数组
     */
    public static function hexToRgb(string $hex): array {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
            return [59, 130, 246]; // 默认蓝色
        }
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
    
    /**
     * RGB数组转hex
     */
    public static function rgbToHex(array $rgb): string {
        return sprintf('#%02X%02X%02X', $rgb[0], $rgb[1], $rgb[2]);
    }
    
    /**
     * 生成favicon
     * @param string $text 文字（1-2个字符最佳）
     * @param string $bgColor 背景颜色hex（如 #3B82F6）
     * @param string $textColor 文字颜色hex（如 #FFFFFF）
     * @param int $size 尺寸（默认32x32）
     * @return string PNG二进制数据
     */
    public static function generate(string $text, string $bgColor = '#3B82F6', string $textColor = '#FFFFFF', int $size = 32): string {
        if (!function_exists('imagecreatetruecolor')) {
            throw new Exception('PHP GD库未安装');
        }
        
        $bgRgb = self::hexToRgb($bgColor);
        $textRgb = self::hexToRgb($textColor);
        
        $img = imagecreatetruecolor($size, $size);
        imageantialias($img, true);
        
        // 开启透明通道
        imagesavealpha($img, true);
        imagealphablending($img, true);
        
        $bg = imagecolorallocate($img, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
        $fg = imagecolorallocate($img, $textRgb[0], $textRgb[1], $textRgb[2]);
        
        // 绘制圆角背景
        self::drawRoundedRect($img, 0, 0, $size, $size, (int)($size * 0.22), $bg);
        
        // 文字
        $text = mb_substr(trim($text), 0, 2, 'UTF-8');
        $textLen = mb_strlen($text, 'UTF-8');
        $fontSize = (int)($textLen === 1 ? $size * 0.62 : $size * 0.42);
        
        $fontFile = self::findFont();
        
        if ($fontFile) {
            $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);
            $tw = $bbox[2] - $bbox[0];
            $th = $bbox[1] - $bbox[7];
            $x = ($size - $tw) / 2 - $bbox[0];
            $y = ($size - $th) / 2 + $th;
            imagettftext($img, $fontSize, 0, (int)$x, (int)$y, $fg, $fontFile, $text);
        } else {
            $font = 5;
            $tw = imagefontwidth($font) * mb_strlen($text);
            $th = imagefontheight($font);
            $x = ($size - $tw) / 2;
            $y = ($size - $th) / 2;
            imagestring($img, $font, (int)$x, (int)$y, $text, $fg);
        }
        
        ob_start();
        imagepng($img, null, 9);
        $data = ob_get_clean();
        if (PHP_VERSION_ID < 80000) {
            imagedestroy($img);
        }
        
        return $data;
    }
    
    /**
     * 绘制圆角矩形并填充
     */
    private static function drawRoundedRect($img, int $x, int $y, int $w, int $h, int $r, $color): void {
        $r = (int)min($r, $w / 2, $h / 2);
        imagefilledrectangle($img, $x, $y, $x + $w, $y + $h, $color);
        // 四角用背景色覆盖成圆角（用透明色遮挡不行，改用重新绘制方案）
        // 简化：直接填充圆角矩形
        $bg = imagecolortransparent($img);
        $mask = imagecreatetruecolor($w, $h);
        imagesavealpha($mask, true);
        $transparent = imagecolorallocatealpha($mask, 0, 0, 0, 127);
        imagefill($mask, 0, 0, $transparent);
        $maskColor = imagecolorallocate($mask, 255, 255, 255);
        imagefilledrectangle($mask, $r, 0, $w - $r, $h, $maskColor);
        imagefilledrectangle($mask, 0, $r, $w, $h - $r, $maskColor);
        // 四个圆角
        imagefilledarc($mask, $r, $r, $r * 2, $r * 2, 180, 270, $maskColor, IMG_ARC_PIE);
        imagefilledarc($mask, $w - $r, $r, $r * 2, $r * 2, 270, 360, $maskColor, IMG_ARC_PIE);
        imagefilledarc($mask, $r, $h - $r, $r * 2, $r * 2, 90, 180, $maskColor, IMG_ARC_PIE);
        imagefilledarc($mask, $w - $r, $h - $r, $r * 2, $r * 2, 0, 90, $maskColor, IMG_ARC_PIE);
        // 应用遮罩
        imagesavealpha($img, true);
        imagealphablending($img, true);
        imagecopy($img, $mask, $x, $y, 0, 0, $w, $h);
        if (PHP_VERSION_ID < 80000) {
            imagedestroy($mask);
        }
    }
    
    /**
     * 查找可用的中文字体
     */
    private static function findFont(): ?string {
        $webFonts = [
            ROOT_PATH . '/assets/fonts/DroidSansFallbackFull.ttf',
            ROOT_PATH . '/assets/fonts/wqy-zenhei.ttc',
        ];
        foreach ($webFonts as $font) {
            if (file_exists($font)) return $font;
        }
        
        $fonts = [
            '/usr/share/fonts/truetype/droid/DroidSansFallbackFull.ttf',
            '/usr/share/fonts/truetype/wqy/wqy-zenhei.ttc',
            '/usr/share/fonts/truetype/wqy/wqy-microhei.ttc',
            '/usr/share/fonts/opentype/noto/NotoSansCJK-Regular.ttc',
            '/usr/share/fonts/truetype/noto/NotoSansCJK-Regular.ttc',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            '/System/Library/Fonts/PingFang.ttc',
            'C:/Windows/Fonts/msyh.ttc',
            'C:/Windows/Fonts/simhei.ttf',
        ];
        
        foreach ($fonts as $font) {
            if (file_exists($font)) return $font;
        }
        
        return null;
    }
}
