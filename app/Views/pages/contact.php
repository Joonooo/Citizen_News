<!-- 성공 메시지 표시 -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- 오류 메시지 표시 -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- 유효성 검사 오류 표시 -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="container my-5">
    <h2>연락처</h2>
    <p>궁금한 점이 있으시거나 오류발견 또는 협업을 원하신다면 언제든지 저에게 연락해 주세요 :)</p>
    <ul>
        <li>Email: <a href="mailto:seonjunwoo@gmail.com">seonjunwoo@gmail.com</a></li>
        <li>GitHub: <a href="https://github.com/Joonooo" target="_blank">github.com/Joonooo</a></li>
    </ul>

    <br>
    <br>

    <h4>연락을 남겨주세요:</h4>

    <br>

    <form action="/send-message" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="name" class="form-label">이름</label> <span class="text-danger">*</span>
            <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">이메일 또는 연락처 <span class="text-danger">*</span></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contact_method" id="contact_email" value="email"
                    <?= old('contact_method') == 'email' || !old('contact_method') ? 'checked' : '' ?> required>
                <label class="form-check-label" for="contact_email">
                    이메일로 연락받기
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contact_method" id="contact_phone" value="phone"
                    <?= old('contact_method') == 'phone' ? 'checked' : '' ?> required>
                <label class="form-check-label" for="contact_phone">
                    휴대전화번호로 연락받기
                </label>
            </div>
            <div class="mt-3">
                <input type="email" class="form-control mb-2" id="email" name="email" placeholder="이메일 주소"
                    value="<?= old('email') ?>" <?= old('contact_method') == 'email' ? '' : 'disabled' ?>>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="휴대전화번호"
                    value="<?= old('phone') ?>" <?= old('contact_method') == 'phone' ? '' : 'disabled' ?>>
            </div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">내용</label>
            <textarea class="form-control" id="message" name="message" rows="4"
                required><?= old('message') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">보내기</button>
    </form>
</div>

<!-- 연락 방법에 따라 입력 필드 활성화/비활성화 스크립트 -->
<script>
    window.addEventListener('load', function () {
        const contactEmail = document.getElementById('contact_email');
        const contactPhone = document.getElementById('contact_phone');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');

        function toggleContactFields() {
            if (contactEmail.checked) {
                emailInput.disabled = false;
                emailInput.required = true;
                phoneInput.disabled = true;
                phoneInput.required = false;
            } else if (contactPhone.checked) {
                emailInput.disabled = true;
                emailInput.required = false;
                phoneInput.disabled = false;
                phoneInput.required = true;
            }
        }

        contactEmail.addEventListener('change', toggleContactFields);
        contactPhone.addEventListener('change', toggleContactFields);

        // 초기 상태 설정
        toggleContactFields();
    });
</script>
