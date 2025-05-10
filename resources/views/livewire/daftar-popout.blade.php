<div class="popout-container" role="complementary" aria-label="Daftarkan Anak Anda popout button">
    <button class="popout-button" aria-expanded="false" aria-controls="popout-content" id="popoutToggle" type="button">
      <span class="popout-header">DAFTARKAN ANAK ANDA</span>
      <div class="popout-content" id="popout-content">
        <img src="{{ asset('build/assets/image 3.png') }}" alt="Daftar Anak" class="popout-image" />
        <a href="daftar-anak.html" class="popout-link" tabindex="0">DAFTAR</a>
      </div>
    </button>
  </div>

  <style>
    /* Reset */
    .popout-container {
      position: fixed;
      top: 1.25rem; /* 20px */
      right: 1.25rem; /* 20px */
      z-index: 50;
      max-width: 320px;
      width: auto;
      max-height: 560px;
      display: flex;
      justify-content: flex-end;
      align-items: flex-start;
      /* bounce animation */
      animation: bounce 2.5s infinite;
    }

    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-8px);
      }
    }

    .popout-button {
      background-color: #3b82f6; /* Tailwind blue-500 */
      color: white;
      border-radius: 9999px; /* pill shape in collapsed */
      box-shadow: 0 12px 24px rgb(59 130 246 / 0.4);
      cursor: pointer;
      user-select: none;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 1.5rem;
      width: auto;
      height: 3.5rem;
      overflow: hidden;
      position: relative;
      transition:
        width 0.45s cubic-bezier(0.4, 0, 0.2, 1),
        box-shadow 0.3s ease,
        background-color 0.3s ease,
        border-radius 0.4s ease;
    }

    .popout-button:hover,
    .popout-button:focus-within,
    .popout-button.expanded {
      width: 320px;
      height: auto;
      padding: 1.25rem 1.5rem 1.75rem 1.5rem;
      box-shadow: 0 24px 48px rgb(59 130 246 / 0.5);
      background-color: #2563eb; /* Tailwind blue-600 */
      border-radius: 1.25rem; /* rounded rectangle on expanded */
      outline: none;
      flex-direction: column;
      align-items: center;
    }

    .popout-header {
      font-weight: 700;
      font-size: 1.125rem; /* 18px */
      white-space: nowrap;
      transition: margin-bottom 0.3s ease;
      user-select: none;
    }

    /* On expanded, margin bottom for header */
    .popout-button:hover .popout-header,
    .popout-button:focus-within .popout-header,
    .popout-button.expanded .popout-header {
      margin-bottom: 0.5rem;
    }

    .popout-content {
      opacity: 0;
      max-height: 0;
      transition: opacity 0.3s ease, max-height 0.4s ease;
      overflow: hidden;
      width: 100%;
      user-select: none;
    }

    .popout-button:hover .popout-content,
    .popout-button:focus-within .popout-content,
    .popout-button.expanded .popout-content {
      opacity: 1;
      max-height: 500px;
    }

    .popout-image {
      max-width: 100%;
      max-height: 160px;
      margin: 0 auto 1rem auto;
      border-radius: 0.75rem;
      object-fit: contain;
      pointer-events: none;
      display: block;
    }

    .popout-link {
      background-color: #f97316; /* Tailwind orange-500 */
      color: rgb(255, 255, 255);
      font-weight: 700;
      text-align: center;
      padding: 0.5rem 1.5rem;
      border-radius: 0.75rem;
      text-decoration: none;
      box-shadow: 0 8px 15px rgb(249 115 22 / 0.4);
      transition: background-color 0.3s ease;
      display: inline-block;
      user-select: none;
      margin: 0 auto;
      width: fit-content;
      min-width: 90px;
    }

    .popout-link:hover,
    .popout-link:focus {
      background-color: #ea580c; /* Tailwind orange-600 */
      outline: none;
    }

    /* For mobile touch - toggle expanded on tap */
    @media (hover: none) and (pointer: coarse) {
      .popout-button {
        width: 320px !important;
        height: auto !important;
        padding: 1.25rem 1.5rem 1.75rem 1.5rem !important;
        box-shadow: 0 24px 48px rgb(59 130 246 / 0.5) !important;
        border-radius: 1.25rem !important;
        background-color: #2563eb !important;
        flex-direction: column !important;
        align-items: center !important;
      }
      .popout-content {
        opacity: 1 !important;
        max-height: 500px !important;
      }
    }
  </style>

  <script>
    // For mobile devices where hover is not available, toggle expand on tap
    document.addEventListener('livewire:load', function () {
      const button = document.getElementById('popoutToggle');
      button.addEventListener('click', () => {
        const expanded = button.getAttribute('aria-expanded') === 'true';
        if(window.matchMedia("(hover: none) and (pointer: coarse)").matches) {
          if(expanded) {
            button.setAttribute('aria-expanded', 'false');
            button.classList.remove('expanded');
          } else {
            button.setAttribute('aria-expanded', 'true');
            button.classList.add('expanded');
          }
        }
      });
    });
  </script>