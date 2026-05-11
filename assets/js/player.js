class MiniPlayer {
  constructor(opts) {
    this.playlist = opts.playlist || [];
    this.autoplay = opts.autoplay || false;
    this.current = 0;
    this.el = null;
    this.listEl = null;
    this.audio = new Audio();
    this.playing = false;
    this.userInteracted = false;
    this._restoreState();
    this._init();
    if (this.playlist.length > 0) {
      this._load(this.current);
      this.el.classList.add('active');
      if (this.autoplay) this._waitForInteraction();
    }
    if (this.savedPlaying) this._waitForInteraction();
  }
  _waitForInteraction() {
    const tryPlay = () => {
      if (this.userInteracted) return;
      this.userInteracted = true;
      this.play();
      document.removeEventListener('click', tryPlay);
      document.removeEventListener('keydown', tryPlay);
      document.removeEventListener('scroll', tryPlay);
      document.removeEventListener('touchstart', tryPlay);
    };
    document.addEventListener('click', tryPlay, { once: true });
    document.addEventListener('keydown', tryPlay, { once: true });
    document.addEventListener('scroll', tryPlay, { once: true });
    document.addEventListener('touchstart', tryPlay, { once: true });
    const titleEl = document.getElementById('mpTitle');
    if (titleEl && !this.playing) {
      titleEl.textContent = this.playlist[this.current]?.title + ' (点击播放)';
    }
  }
  _restoreState() {
    this.savedIdx = parseInt(localStorage.getItem('mp_idx') || '0');
    this.savedTime = parseFloat(localStorage.getItem('mp_time') || '0');
    this.savedPlaying = localStorage.getItem('mp_playing') === '1';
    if (this.savedIdx >= 0 && this.savedIdx < this.playlist.length) {
      this.current = this.savedIdx;
    }
  }
  _init() {
    if (this.el) return;
    const d = document.createElement('div');
    d.className = 'mini-player';
    d.innerHTML = `
      <button class="mp-play" id="mpBtn">▶</button>
      <button class="mp-prev" id="mpPrev">◀◀</button>
      <div class="mp-info">
        <div class="mp-title" id="mpTitle">加载中...</div>
        <div class="mp-time"><span id="mpCur">0:00</span> / <span id="mpDur">0:00</span></div>
      </div>
      <button class="mp-next" id="mpNext">▶▶</button>
      <button class="mp-list-btn" id="mpListBtn">☰</button>
      <div class="mp-bar" id="mpBar"><div class="mp-bar-fill" id="mpFill"></div></div>
      <div class="mp-visualizer" id="mpVis">${Array(5).fill(0).map(()=>'<span style="height:3px"></span>').join('')}</div>
      <button class="mp-close" id="mpClose">✕</button>
      <div class="mp-list" id="mpList" style="display:none"></div>
    `;
    document.body.appendChild(d);
    this.el = d;
    this.listEl = document.getElementById('mpList');
    this._renderList();
    
    this.audio.preload = 'auto';
    this.audio.addEventListener('loadedmetadata', () => {
      document.getElementById('mpDur').textContent = this._fmt(this.audio.duration);
      if (this.savedTime > 0 && this.current === this.savedIdx) {
        this.audio.currentTime = Math.min(this.savedTime, this.audio.duration);
        this.savedTime = 0;
      }
    });
    this.audio.addEventListener('timeupdate', () => {
      document.getElementById('mpCur').textContent = this._fmt(this.audio.currentTime);
      const pct = (this.audio.currentTime / this.audio.duration) * 100;
      document.getElementById('mpFill').style.width = pct + '%';
      localStorage.setItem('mp_time', this.audio.currentTime);
    });
    this.audio.addEventListener('ended', () => this._next(true));
    document.getElementById('mpBtn').onclick = () => this.toggle();
    document.getElementById('mpPrev').onclick = () => this._prev();
    document.getElementById('mpNext').onclick = () => this._next(false);
    document.getElementById('mpBar').onclick = (e) => {
      const rect = e.currentTarget.getBoundingClientRect();
      this.audio.currentTime = ((e.clientX - rect.left) / rect.width) * this.audio.duration;
    };
    document.getElementById('mpClose').onclick = () => {
      this.pause();
      this.el.classList.remove('active');
      localStorage.setItem('mp_playing', '0');
    };
    document.getElementById('mpListBtn').onclick = () => this._toggleList();
    window.addEventListener('beforeunload', () => {
      localStorage.setItem('mp_idx', this.current);
      localStorage.setItem('mp_time', this.audio.currentTime);
      localStorage.setItem('mp_playing', this.playing ? '1' : '0');
    });
  }
  _renderList() {
    if (!this.listEl) return;
    this.listEl.innerHTML = this.playlist.map((s, i) => 
      `<div class="mp-list-item${i===this.current?' on':''}" data-idx="${i}">
        <span class="mp-list-num">${i+1}</span>
        <span class="mp-list-title">${s.title}</span>
      </div>`
    ).join('');
    this.listEl.querySelectorAll('.mp-list-item').forEach(item => {
      item.onclick = () => {
        this._load(parseInt(item.dataset.idx));
        this.play();
      };
    });
  }
  _toggleList() {
    if (this.listEl) this.listEl.style.display = this.listEl.style.display === 'none' ? 'block' : 'none';
  }
  _load(idx) {
    if (!this.playlist[idx]) return;
    this.current = idx;
    this.audio.src = this.playlist[idx].url;
    this.audio.load();
    const titleEl = document.getElementById('mpTitle');
    if (titleEl) titleEl.textContent = this.playlist[idx].title;
    this._renderList();
  }
  _next(autoPlay) {
    this._load((this.current + 1) % this.playlist.length);
    this.audio.currentTime = 0;
    if (autoPlay || this.playing) this.play();
  }
  _prev() {
    this._load((this.current - 1 + this.playlist.length) % this.playlist.length);
    this.audio.currentTime = 0;
    this.play();
  }
  toggle() { this.playing ? this.pause() : this.play(); }
  play() {
    this.audio.play().then(() => {
      this.playing = true;
      this.el.classList.add('active');
      document.getElementById('mpBtn').textContent = '⏸';
      document.getElementById('mpVis').classList.add('playing');
      localStorage.setItem('mp_playing', '1');
      const t = document.getElementById('mpTitle');
      if (t) t.textContent = this.playlist[this.current]?.title || '';
    }).catch(e => {
      const t = document.getElementById('mpTitle');
      if (t) t.textContent = this.playlist[this.current]?.title + ' (播放失败)';
    });
  }
  pause() {
    this.audio.pause();
    this.playing = false;
    document.getElementById('mpBtn').textContent = '▶';
    document.getElementById('mpVis').classList.remove('playing');
    localStorage.setItem('mp_playing', '0');
  }
  _fmt(s) {
    if (isNaN(s)) return '0:00';
    const m = Math.floor(s / 60), sec = Math.floor(s % 60);
    return m + ':' + (sec < 10 ? '0' : '') + sec;
  }
}