<?php
require __DIR__ . '/parts/pdo-connect.php';
$title = '登入'; #設定TITLE
$page_name = 'login';
?>

<?php include __DIR__ . '/parts/html-head.php'
?>

<style>
  .form-warning-text {
    color:brown ;
  }

  body {
    background: linear-gradient(#353364, #333766, #323a68, #313e6a, #30416b, #36436c, #3b456e, #40476f, #4b496f, #544b70, #5d4d6f, #654f6f);
    background-size: cover;
    width: 100vw;
    height: 100vh;
  }
  canvas {
      position: absolute;
      top: 0;
      left: 0;    
    }

  h6,
  h2,
  h5 {
    font-weight: 800;
  }

  .bg-card {

    --bs-bg-opacity: 0.7;
    background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important;
    box-shadow: 1px 1px 20px;
  }
</style>

<!-- 主要內容開始 -->
<canvas id="particleCanvas"></canvas>
<div class="container">

  <div class="container">
    <div class="row justify-content-center 
align-content-center" style="height: 95vh;">
      <h2 class="text-center text-white">毛毛救星</h2>
      <h6 class="text-center text-white">後臺系統管理登入</h6>
      <div class="col-lg-6 col-md-12">
        <div class="card bg-card card border-light mb-3">
          <div class="card-body">
          </div>
          <div class="card-body">
            <h5 class="card-title text-center mb-3">使用者登入</h5>
            <form class="d-flex flex-column  align-items-center" name="form1" onsubmit="sendData(event)">
              <!-- 此處不用 method="post"，因為沒有要用傳統的表單送出  -->
              <div class="col-10">
                <div class="mb-3">
                  <label for="email" class="form-label text-body">Email</label>
                  <input type="text" class="form-control" id="email" name="email">
                  <div class="form-warning-text"></div>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label text-body">密碼</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <div class="form-warning-text"></div>

                </div>
                <div style="width:100%" class="d-flex justify-content-between">
                  <a href="#" class="link-secondary">忘記密碼?</a>
                  <button type="submit" class="btn col-6 btn-dark">登入</button>
                </div>
              </div>
            </form>
          </div>
          <div class="card-body">
          </div>
        </div>
        <figure class="text-end"> 
        <a href="" class="link-light text-end"><i class="fa-solid fa-arrow-right-to-bracket"></i> 返回《毛毛救星》</a>
        </figure>
      </div>
    </div>
  </div>
 

  <!-- Modal-失敗 -->
  <div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">登入失敗</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" role="alert" id="failureInfo">
            帳號或密碼錯誤
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          <a href="list.php" class="btn btn-primary">跳至列表頁</a>
        </div>
      </div>
    </div>
  </div>
  <!-- 主要內容結束 -->
  <?php include __DIR__ . '/parts/script.php'
  ?>
  <script>
    const {
      email: emailEl,
      password: passwordEl
    } = document.form1 //以解構的方式拿資料El=Element
    //物件document.form1的屬性設定在{}裡面

    const fields = [emailEl, passwordEl]; //抓每個欄位成陣列,下面回復欄位迴圈需用到

    function validateEmail(email) {
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }

    // function validateMobile(password) {
    //   const re = /^09\d{2}-?\d{3}-?\d{3}$/ //檢查字串
    //   return re.test(password);
    // }

    function sendData(e) {
      //回復欄位的外觀
      /*   nameEl.style.border = '1px solid #CCC';
      nameEl.nextElementSibling.innerHTML = '';
      emailEl.style.border = '1px solid #CCC';
      emailEl.nextElementSibling.innerHTML = '';
      mobilEl.style.border = '1px solid #CCC';
      mobilEl.nextElementSibling.innerHTML = '';  
      改寫成迴圈:*/


      for (let el of fields) {
        el.style.border = '1px solid #CCC';
        el.nextElementSibling.innerHTML = '';
      }

      e.preventDefault(); //不要讓表單以傳統方式送出

      let isPass = true; //整個表單有沒有通過檢查

      //TODO:檢查表單個欄位有沒有符合規範

      if (emailEl.value && !validateEmail(emailEl.value)) {
        isPass = false;
        emailEl.style.border = '1px solid #red';
        emailEl.nextElementSibling.innerHTML = '請填寫正確的Email';
      }

      if (isPass) { //if(isPass){}通過才送出表單
        const fd = new FormData(document.form1);
        //把表單內容複製到沒有外觀的表單物件(有外觀=上面form標籤,有外觀才能讓使用者輸入資料)fd變數名稱=formdata , new+類型(FormData)}

        //fetch(送到哪裡,用甚麼方式)
        fetch(`login-api.php`, { //TypeScript
          method: 'POST',
          body: fd
        }).then(r => r.json()).then(data => {
          console.log(data);
          if (data.success) {
            location.href = 'index_.php' //前端(JS的跳轉)
          } else {
            failureModal.show();
          }


        }) //data => {}輸出到add-api-output
      }
    }

    const failureModal = new bootstrap.Modal('#failureModal')


    //粒子背景
    const canvas = document.getElementById("particleCanvas");
  const ctx = canvas.getContext("2d");
  let particles = [];
  const particleCount = 300;

  // Particle class
  class Particle {
    constructor() {
      this.size = Math.random() * 1 + 0.1; // 调整初始大小范围
      this.reset();
    }

    reset() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height;
      this.speedX = Math.random() * 0.2 - 0.1;
      this.speedY = Math.random() * 0.2 - 0.1;
    }

    update() {
      this.x += this.speedX;
      this.y += this.speedY;

      // Wrap particles around the screen
      if (this.x > canvas.width + 5 || this.x < -5 || this.y > canvas.height + 5 || this.y < -5) {
        this.reset();
      }
    }

    draw() {
      ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  function createParticles() {
    particles = [];
    for (let i = 0; i < particleCount; i++) {
      particles.push(new Particle());
    }
  }

  function animateParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < particles.length; i++) {
      particles[i].update();
      particles[i].draw();
    }

    requestAnimationFrame(animateParticles);
  }

  function handleResize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    createParticles();
  }

  window.addEventListener("resize", handleResize);

  // 初始化时创建粒子
  handleResize();
  animateParticles();
</script>
  </script>
  <?php include __DIR__ . '/parts/html-foot.php'
  ?>