@props([
    'message' => ''
])

<div class="toast toast-start"
     x-data="{ toastText:  'Сообщение в тосте', showToast: false}"
     x-show="showToast"
     x-init="window.addEventListener('show-toast', (e) => {
    showToast = true;
    toastText = e.detail[0];
    setTimeout(() => showToast = false, e.detail[1] ?? 2000);
   });"
>
  <div class="alert alert-success">
    <span x-text="toastText"></span>
  </div>
</div>

@if (session('toast'))
  <div class="toast toast-start"
       x-data="{ showToast: true}"
       x-show="showToast"
       x-init="setTimeout(() => showToast = false, 2000)"
  >
    <div class="alert alert-success">
      <span>{{ session('toast') }}</span>
    </div>
  </div>
@endif
