window.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("Slide_Popup");
    if (!popup) return;
    //making sure it only shows once when a person enters the website
    if (sessionStorage.getItem("popupShown") === "true") {
        popup.style.display = "none";
        return;}
    setTimeout(() => {
        popup.classList.add("show");
        sessionStorage.setItem("popupShown", "true");
    }, 100);
    setTimeout(() => {
        popup.classList.remove("show");
        setTimeout(() => {
            popup.style.display = "none";
        }, 500); 
    }, 4500);
});


//authenticated account dropdown nav toggle on/off, optional method. mobile 
function toggleMenu() {
    const menu = document.getElementById("DropDownMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
} // closing the menu when mouse is outside
document.addEventListener("click", function(e) {
    const menu = document.getElementById("DropDownMenu");
    const button = document.querySelector(".account-shape");
    if (!button.contains(e.target) && !menu.contains(e.target)) {
        menu.style.display = "none";
    }
});



//flying lines on hero section. Gathered on the internet website background template. 
 const canvas = document.getElementById('linesCanvas');
  const ctx    = canvas.getContext('2d');
  const hero   = canvas.parentElement;
  let W, H, lines = [];

 function resize() {
  const rect = hero.getBoundingClientRect();

  W = canvas.width  = rect.width;
  H = canvas.height = rect.height;

  canvas.style.width  = rect.width + "px";
  canvas.style.height = rect.height + "px";
}

  function rand(a, b) { return Math.random() * (b - a) + a; }

  function spawnLine() {
    const edge  = Math.floor(Math.random() * 4);
    let x, y, angle;

    if      (edge === 0) { x = rand(0, W); y = -10;    angle = rand(60, 120);  }
    else if (edge === 1) { x = W + 10;    y = rand(0,H); angle = rand(150, 210); }
    else if (edge === 2) { x = rand(0, W); y = H + 10;  angle = rand(240, 300); }
    else                 { x = -10;        y = rand(0,H); angle = rand(-30, 30);  }

    const rad   = angle * Math.PI / 180;
    const speed  = rand(0.6, 1.6);
    const length = rand(60, 180);

    return {
      x, y,
      vx: Math.cos(rad) * speed,
      vy: Math.sin(rad) * speed,
      length,
      alpha: rand(0.06, 0.18),
      width: rand(0.5, 1.5),
      hue:   Math.random() < 0.7 ? 263 : rand(250, 280),
      trail: [],
      age: 0,
      maxAge: Math.round(length / speed) + rand(40, 120),
      dead: false
    };
  }

  function init() {
    resize();
    for (let i = 0; i < 18; i++) {
      const l = spawnLine();
      l.age = rand(0, l.maxAge);
      lines.push(l);
    }
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);

    // slowly spawn new lines
    if (lines.length < 22 && Math.random() < 0.03) lines.push(spawnLine());

    lines.forEach(l => {
      l.trail.push({ x: l.x, y: l.y });
      if (l.trail.length > l.length) l.trail.shift();

      l.x += l.vx;
      l.y += l.vy;
      l.age++;


      const t = l.trail;
      for (let i = 1; i < t.length; i++) {
        const progress = i / t.length;
        const fade = progress < 0.3
          ? progress / 0.3
          : progress > 0.85
            ? (1 - progress) / 0.15
            : 1;

        ctx.beginPath();
        ctx.moveTo(t[i-1].x, t[i-1].y);
        ctx.lineTo(t[i].x,   t[i].y);
        ctx.strokeStyle = `hsla(${l.hue}, 72%, 58%, ${l.alpha * fade})`;
        ctx.lineWidth   = l.width;
        ctx.lineCap     = 'round';
        ctx.stroke();
      }


      if (l.age > l.maxAge) l.trail.shift();
      if (l.x < -200 || l.x > W+200 || l.y < -200 || l.y > H+200) l.dead = true;
      if (l.age > l.maxAge && l.trail.length === 0) l.dead = true;
    });

    lines = lines.filter(l => !l.dead);
    requestAnimationFrame(draw);
  }

  window.addEventListener('resize', resize);
  init();
  draw();

  //end of flying lines script 


//making successful button show then fade after line closes
window.addEventListener("DOMContentLoaded", () => {
    const popupmessage = document.getElementById("login_message");
    if (!popupmessage) return;
    const line = popupmessage.querySelector(".progress_line");
    setTimeout(() => {
        popupmessage.classList.add("show");
        if (line) {
            line.style.transition = "width 3s linear";
            line.style.width = "100%"; 
        } }, 100);
    setTimeout(() => {
        popupmessage.style.opacity = '0';  
        setTimeout(() => {
            popupmessage.classList.remove("show");
            popupmessage.style.top = "-100px";  
            if (line) line.style.width = "0%"; 
        }, 200); 
    }, 3100);
});




//reveal animation when scrolling down. adding to any class element when needed.
 const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');});
  },{ threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));






//removing discovered and putting in hired, improving appearance
window.onload = function () {
  const el = document.getElementById("change");
  //what word we be changing with. index gone, then return after a while 
  const words = ["Discovered", "Hired"];
  let index = 0;
  setInterval(() => {
    el.style.opacity = 0;
    setTimeout(() => {
      index = (index + 1) % words.length;
      el.textContent = words[index];
      el.style.opacity = 1;
    }, 0);
  }, 10000);
};




//timeline progession animation. list y position and where-ever that is, update
//primary color on it
const timeline = document.querySelector(".vertical-line");
const progress = document.querySelector(".timeline-progress");
window.addEventListener("scroll", () => {
    const scrollTop = window.scrollY;
    const windowHeight = window.innerHeight;
    const timelineTop = timeline.offsetTop;
    const timelineHeight = timeline.offsetHeight;
    const start = timelineTop - windowHeight;
    const end = timelineTop + timelineHeight - windowHeight * 0.4;
    let progressPercent = (scrollTop - start) / (end - start);
    progressPercent = Math.max(0, Math.min(1, progressPercent));
    progress.style.height = (progressPercent * 100) + "%";
});




//opening and closing 
document.addEventListener("DOMContentLoaded", () => {
    const faqItems = document.querySelectorAll(".faq-item");
    faqItems.forEach(item => {
        item.querySelector(".faq-question").addEventListener("click", () => {
           faqItems.forEach(i => {
              if (i !== item) i.classList.remove("active");
            });
            
            item.classList.toggle("active");
        });
    });
});



//CV form page, JS 

// Profile CV form. Adding experience to the user. DB will be added automatically but this is just for ue
document.addEventListener("DOMContentLoaded", () => {
    const cvForm = document.querySelector('.cv-form');
    if (cvForm) {
        cvForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.cv-submit-btn');
            if (submitBtn) {
                submitBtn.textContent = 'Saving...';
                submitBtn.disabled = true;
            }
        });
    }
});


// allowing a person to input more than one link. Max is going to be 3
function updateAddUrlButton() {
    const container = document.getElementById('urls-container');
    const addBtn = document.querySelector('.btn-add-url');
    if (!container || !addBtn) return;
    const currentFields = container.querySelectorAll('.url-field-wrapper').length;
    addBtn.style.display = currentFields >= 3 ? 'none' : 'inline-block';
}
function addUrlField() {
    const container = document.getElementById('urls-container');
    const currentFields = container.querySelectorAll('.url-field-wrapper').length;
    // making sure no more than 3
    if (currentFields >= 3) {
        alert("You can only add up to 3 URLs.");
        return; 
    }
    //different placeholder for different link. allow person to know what to input
    // or give them a idea of what to put
    const placeholders = [
        'https://github.com/your-username',
        'https://linkedin.com/in/your-name',
        'https://your-portfolio.com'
    ];
    const placeholder = placeholders[currentFields] || 'https://your-link.com';
    const newFieldWrapper = document.createElement('div');
    newFieldWrapper.className = 'url-field-wrapper';
    newFieldWrapper.innerHTML = `
        <input type="url" name="URLlinks[]" class="url-input" placeholder="${placeholder}">
        <button type="button" class="btn-remove-url" onclick="removeUrlField(this)">X</button>`;
    container.appendChild(newFieldWrapper);
    newFieldWrapper.querySelector('.url-input').focus();
    updateAddUrlButton();
}
//if the user has already three URL links in the form, we are going to 
// remove the +Add link button as it makes the website just clean
function removeUrlField(btn) {
    const wrapper = btn.closest('.url-field-wrapper');
    wrapper.remove();
    updateAddUrlButton();
}
function initUrlButtons() {
    updateAddUrlButton();
}

if (document.readyState === 'loading') {
    window.addEventListener('DOMContentLoaded', initUrlButtons);
} else {
    initUrlButtons();
}

//CV form page, JS end//