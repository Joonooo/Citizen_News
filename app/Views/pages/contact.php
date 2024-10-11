<!-- 성공 메시지 표시 -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="닫기"></button>
    </div>
<?php endif; ?>

<!-- 오류 메시지 표시 -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="닫기"></button>
    </div>
<?php endif; ?>

<!-- 유효성 검사 오류 표시 -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="닫기"></button>
    </div>
<?php endif; ?>

<div class="container my-5">
    <h2 class="mb-4">연락하기</h2>
    <p>궁금한 점이 있으시거나 협업을 원하신다면 언제든지 저에게 연락해 주세요 :)</p>
    <ul class="list-inline">
        <li class="list-inline-item me-3">
            <i class="bi bi-envelope-fill"></i> <a href="mailto:seonjunwoo@gmail.com">seonjunwoo@gmail.com</a>
        </li>
        <li class="list-inline-item">
            <i class="bi bi-github"></i> <a href="https://github.com/Joonooo" target="_blank">GitHub 프로필</a>
        </li>
    </ul>

    <hr class="my-5">

    <h4 class="mb-4">문의사항을 남겨주세요</h4>

    <form action="/send-message" method="post" novalidate>
        <?= csrf_field() ?>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">이름 <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ?>" required>
                <?php if (isset($errors['name'])): ?>
                    <div class="invalid-feedback">
                        <?= esc($errors['name']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">연락 방법 <span class="text-danger">*</span></label>
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
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div id="emailField" class="<?= old('contact_method') == 'email' || !old('contact_method') ? '' : 'd-none' ?>">
                    <label for="email" class="form-label">이메일 주소 <span class="text-danger">*</span></label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="example@example.com" value="<?= old('email') ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback">
                            <?= esc($errors['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div id="phoneField" class="<?= old('contact_method') == 'phone' ? '' : 'd-none' ?>">
                    <label for="phone" class="form-label">휴대전화번호 <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" id="phone" name="phone" placeholder="010-1234-5678" value="<?= old('phone') ?>">
                    <?php if (isset($errors['phone'])): ?>
                        <div class="invalid-feedback">
                            <?= esc($errors['phone']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">내용 <span class="text-danger">*</span></label>
            <textarea class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>" id="message" name="message" rows="6" required><?= old('message') ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="invalid-feedback">
                    <?= esc($errors['message']) ?>
                </div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">메시지 보내기</button>
    </form>
</div>

<!-- 연락 방법에 따라 입력 필드 활성화/비활성화 스크립트 -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contactEmail = document.getElementById('contact_email');
        const contactPhone = document.getElementById('contact_phone');
        const emailField = document.getElementById('emailField');
        const phoneField = document.getElementById('phoneField');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');

        function toggleContactFields() {
            if (contactEmail.checked) {
                emailField.classList.remove('d-none');
                phoneField.classList.add('d-none');
                emailInput.required = true;
                phoneInput.required = false;
                phoneInput.value = '';
            } else if (contactPhone.checked) {
                emailField.classList.add('d-none');
                phoneField.classList.remove('d-none');
                emailInput.required = false;
                phoneInput.required = true;
                emailInput.value = '';
            }
        }

        contactEmail.addEventListener('change', toggleContactFields);
        contactPhone.addEventListener('change', toggleContactFields);

        // 초기 상태 설정
        toggleContactFields();
    });
</script>