        // 主题切换功能
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }

        // 页面加载时恢复主题
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        });

        // 微信弹窗功能
        function showWechatModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            document.getElementById('wechatModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideWechatModal(event) {
            if (event && event.target !== event.currentTarget) {
                return;
            }
            document.getElementById('wechatModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // 按 ESC 关闭弹窗
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideWechatModal();
            }
        });

/**
