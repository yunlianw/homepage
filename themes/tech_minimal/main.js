const body = document.body;
const themeButtons = document.querySelectorAll('.theme-btn');

function setTheme(theme) {
  body.dataset.theme = theme;
  localStorage.setItem('personal-home-theme', theme);
  themeButtons.forEach(btn => btn.classList.toggle('active', btn.dataset.themeValue === theme));
}

const savedTheme = localStorage.getItem('personal-home-theme') || 'light';
setTheme(savedTheme);

themeButtons.forEach(btn => {
  btn.addEventListener('click', () => setTheme(btn.dataset.themeValue));
});

const cursorGlow = document.getElementById('cursorGlow');
if (cursorGlow) {
  window.addEventListener('mousemove', (event) => {
    cursorGlow.style.left = event.clientX + 'px';
    cursorGlow.style.top = event.clientY + 'px';
  });
}

const canvas = document.getElementById('particleCanvas');
const ctx = canvas.getContext('2d');
let particles = [];
let mouse = { x: null, y: null, radius: 130 };

function getRgbVar(name) {
  return getComputedStyle(body).getPropertyValue(name).trim() || '143, 182, 216';
}

function resizeCanvas() {
  canvas.width = window.innerWidth * devicePixelRatio;
  canvas.height = window.innerHeight * devicePixelRatio;
  canvas.style.width = window.innerWidth + 'px';
  canvas.style.height = window.innerHeight + 'px';
  ctx.setTransform(devicePixelRatio, 0, 0, devicePixelRatio, 0, 0);
  initParticles();
}

function initParticles() {
  particles = [];
  const count = Math.min(150, Math.floor((window.innerWidth * window.innerHeight) / 13000));
  for (let i = 0; i < count; i++) {
    particles.push({
      x: Math.random() * window.innerWidth,
      y: Math.random() * window.innerHeight,
      r: Math.random() * 1.7 + 0.5,
      vx: (Math.random() - 0.5) * 0.22,
      vy: (Math.random() - 0.5) * 0.22,
      a: Math.random() * 0.46 + 0.18
    });
  }
}

function drawParticles() {
  const particleColor = getRgbVar('--particle');
  const lineColor = getRgbVar('--particle-line');
  ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);

  particles.forEach(p => {
    p.x += p.vx;
    p.y += p.vy;
    if (p.x < -10) p.x = window.innerWidth + 10;
    if (p.x > window.innerWidth + 10) p.x = -10;
    if (p.y < -10) p.y = window.innerHeight + 10;
    if (p.y > window.innerHeight + 10) p.y = -10;

    let boost = 0;
    if (mouse.x !== null) {
      const dx = p.x - mouse.x;
      const dy = p.y - mouse.y;
      const dist = Math.sqrt(dx * dx + dy * dy);
      if (dist < mouse.radius) boost = (mouse.radius - dist) / mouse.radius;
    }

    ctx.beginPath();
    ctx.fillStyle = `rgba(${particleColor}, ${Math.min(0.9, p.a + boost * 0.35)})`;
    ctx.shadowBlur = 10 + boost * 12;
    ctx.shadowColor = `rgba(${particleColor}, 0.45)`;
    ctx.arc(p.x, p.y, p.r + boost * 0.6, 0, Math.PI * 2);
    ctx.fill();
  });

  ctx.shadowBlur = 0;
  for (let i = 0; i < particles.length; i++) {
    for (let j = i + 1; j < particles.length; j++) {
      const a = particles[i];
      const b = particles[j];
      const dx = a.x - b.x;
      const dy = a.y - b.y;
      const dist = Math.sqrt(dx * dx + dy * dy);
      if (dist < 105) {
        ctx.beginPath();
        ctx.strokeStyle = `rgba(${lineColor}, ${(1 - dist / 105) * 0.08})`;
        ctx.lineWidth = 1;
        ctx.moveTo(a.x, a.y);
        ctx.lineTo(b.x, b.y);
        ctx.stroke();
      }
    }
  }
  requestAnimationFrame(drawParticles);
}

window.addEventListener('mousemove', e => {
  mouse.x = e.clientX;
  mouse.y = e.clientY;
});
window.addEventListener('mouseleave', () => {
  mouse.x = null;
  mouse.y = null;
});
window.addEventListener('resize', resizeCanvas);
resizeCanvas();
drawParticles();

function scanType(el, speed = 28) {
  const finalText = el.dataset.text || el.textContent.trim();
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789<>/[]{}-=+_*一二三四五六七八九十';
  let frame = 0;
  const timer = setInterval(() => {
    let output = '';
    for (let i = 0; i < finalText.length; i++) {
      output += i < frame ? finalText[i] : chars[Math.floor(Math.random() * chars.length)];
    }
    el.textContent = output;
    frame += 0.6;
    if (frame >= finalText.length + 1) {
      clearInterval(timer);
      el.textContent = finalText;
    }
  }, speed);
}

window.addEventListener('load', () => {
  document.querySelectorAll('.scan-text').forEach((el, index) => {
    setTimeout(() => scanType(el, 24), 160 + index * 170);
  });
});

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

document.querySelectorAll('.glass').forEach(card => {
  card.addEventListener('mousemove', event => {
    if (window.innerWidth < 900) return;
    const rect = card.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
    const rotateX = ((y / rect.height) - 0.5) * -2.2;
    const rotateY = ((x / rect.width) - 0.5) * 2.2;
    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-2px)`;
  });
  card.addEventListener('mouseleave', () => { card.style.transform = ''; });
});

const papers = document.querySelectorAll('.paper');
const bookProgress = document.getElementById('bookProgress');
const bookStatusText = document.getElementById('bookStatusText');
const nextPageBtn = document.getElementById('nextPageBtn');
const prevPageBtn = document.getElementById('prevPageBtn');
const resetBookBtn = document.getElementById('resetBookBtn');
const pageTitles = ['视频网站系统', '核心亮点', '网站监控系统', '扩展方向', '个人数据看板', '后续计划'];
let currentPaper = 0;

if (papers.length > 0) {
  function updateBook() {
    papers.forEach((paper, index) => {
      if (index < currentPaper) {
        paper.classList.add('flipped');
        paper.style.zIndex = index + 1;
      } else {
        paper.classList.remove('flipped');
        paper.style.zIndex = papers.length - index + 10;
      }
    });
    const totalPages = papers.length * 2;
    let logicalPage = Math.min(totalPages, currentPaper * 2 + 1);
    if (currentPaper === papers.length) logicalPage = totalPages;
    if (bookProgress) bookProgress.style.width = ((logicalPage - 1) / (totalPages - 1)) * 100 + '%';
    if (bookStatusText) bookStatusText.textContent = `第 ${logicalPage} / ${totalPages} 页 · ${pageTitles[logicalPage - 1] || pageTitles[0]}`;
  }

  function nextPage() {
    currentPaper = currentPaper < papers.length ? currentPaper + 1 : 0;
    updateBook();
  }

  function prevPage() {
    currentPaper = currentPaper > 0 ? currentPaper - 1 : papers.length;
    updateBook();
  }

  if (nextPageBtn) nextPageBtn.addEventListener('click', nextPage);
  if (prevPageBtn) prevPageBtn.addEventListener('click', prevPage);
  if (resetBookBtn) resetBookBtn.addEventListener('click', () => { currentPaper = 0; updateBook(); });
  papers.forEach((paper, index) => {
    paper.addEventListener('click', () => {
      if (index === currentPaper) nextPage();
      else if (index < currentPaper) { currentPaper = index; updateBook(); }
    });
  });
  updateBook();
}

const weatherTemp = document.getElementById('weatherTemp');
const weatherDesc = document.getElementById('weatherDesc');
const weatherLocation = document.getElementById('weatherLocation');
const weatherWind = document.getElementById('weatherWind');
const weatherStatus = document.getElementById('weatherStatus');
const weatherIcon = document.getElementById('weatherIcon');

if (weatherTemp) {

function weatherText(code) {
  const map = {0:'晴朗',1:'大致晴朗',2:'局部多云',3:'阴天',45:'有雾',48:'霜雾',51:'毛毛雨',53:'小毛雨',55:'中毛雨',61:'小雨',63:'中雨',65:'大雨',71:'小雪',73:'中雪',75:'大雪',80:'阵雨',81:'强阵雨',82:'暴雨阵雨',95:'雷暴',96:'雷暴伴小冰雹',99:'强雷暴伴冰雹'};
  return map[code] || '未知天气';
}

function weatherSvg(code) {
  const c = 'var(--accent-deep)';
  const cloud = 'currentColor';
  if (code === 0) return `<svg width="44" height="44" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="32" r="11" stroke="${c}" stroke-width="3"/><g stroke="${c}" stroke-width="3" stroke-linecap="round"><path d="M32 8v8M32 48v8M8 32h8M48 32h8M15 15l6 6M43 43l6 6M49 15l-6 6M21 43l-6 6"/></g></svg>`;
  if ([1,2,3,45,48].includes(code)) return `<svg width="44" height="44" viewBox="0 0 64 64" fill="none"><path d="M18 42c-5 0-9-4-9-9s4-9 9-9c1 0 2 0 3 .4C23 19 28 16 34 16c8 0 14 6 14 14h1c5 0 9 4 9 9s-4 9-9 9H18z" stroke="${cloud}" stroke-width="3" stroke-linejoin="round"/></svg>`;
  if ([51,53,55,61,63,65,80,81,82].includes(code)) return `<svg width="44" height="44" viewBox="0 0 64 64" fill="none"><path d="M18 36c-5 0-9-4-9-9s4-9 9-9c1 0 2 0 3 .4C23 13 28 10 34 10c8 0 14 6 14 14h1c5 0 9 4 9 9s-4 9-9 9H18z" stroke="${cloud}" stroke-width="3"/><g stroke="${c}" stroke-width="3" stroke-linecap="round"><path d="M23 44l-3 7M33 44l-3 7M43 44l-3 7"/></g></svg>`;
  if ([71,73,75].includes(code)) return `<svg width="44" height="44" viewBox="0 0 64 64" fill="none"><path d="M18 34c-5 0-9-4-9-9s4-9 9-9c1 0 2 0 3 .4C23 11 28 8 34 8c8 0 14 6 14 14h1c5 0 9 4 9 9s-4 9-9 9H18z" stroke="${cloud}" stroke-width="3"/><g stroke="${c}" stroke-width="2.5" stroke-linecap="round"><path d="M22 46h8M26 42v8M23 43l6 6M29 43l-6 6M38 46h8M42 42v8M39 43l6 6M45 43l-6 6"/></g></svg>`;
  return `<svg width="44" height="44" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="32" r="12" stroke="${c}" stroke-width="3"/></svg>`;
}

async function loadWeather(lat, lon) {
  try {
    weatherStatus.textContent = '正在读取天气';
    const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code,wind_speed_10m&timezone=auto`;
    const reverseUrl = `https://geocoding-api.open-meteo.com/v1/reverse?latitude=${lat}&longitude=${lon}&language=zh&count=1`;
    const [weatherRes, reverseRes] = await Promise.all([fetch(weatherUrl), fetch(reverseUrl)]);
    const weatherData = await weatherRes.json();
    const reverseData = await reverseRes.json();
    const current = weatherData.current;
    const place = reverseData.results && reverseData.results[0];
    weatherTemp.textContent = `${Math.round(current.temperature_2m)}°C`;
    weatherDesc.textContent = weatherText(current.weather_code);
    weatherWind.textContent = `${current.wind_speed_10m} km/h`;
    weatherLocation.textContent = place ? `${place.name}${place.admin1 ? ' · ' + place.admin1 : ''}` : '已定位';
    weatherStatus.textContent = '实时天气已更新';
    weatherIcon.innerHTML = weatherSvg(current.weather_code);
  } catch (e) {
    weatherStatus.textContent = '天气接口请求失败';
    weatherDesc.textContent = '无法读取天气数据';
  }
}

function loadDefaultWeather() {
  weatherStatus.textContent = '未获得定位，使用默认城市';
  loadWeather(39.9042, 116.4074);
}

if ('geolocation' in navigator) {
  navigator.geolocation.getCurrentPosition(
    pos => loadWeather(pos.coords.latitude, pos.coords.longitude),
    () => loadDefaultWeather(),
    { enableHighAccuracy: true, timeout: 8000, maximumAge: 60000 }
  );
} else {
  loadDefaultWeather();
}
} // end if (weatherTemp)
