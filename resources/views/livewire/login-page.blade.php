<div class="container container-normal ">
    <div class="row align-items-center g-4">
        <div class="col-lg">
            <div class="container-tight">
                <div class="text-center mb-4">
                    <img src="{{ asset(env('LOGO')) }}" alt="L" class="avatar avatar-xl">
                </div>
                <div class="card card-md">

                    <div class="card-body">
                        <h2 class="h2 text-center mb-4">CONNEXION</h2>
                        <form wire:submit="login">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" wire:model="email" placeholder="Votre email" autocomplete="off" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">
                                    Mot de passe
                                    <span class="form-label-description">
                                        <a href="./forgot-password.html">Mot de passe oublié</a>
                                    </span>
                                </label>
                                <div class="input-group input-group-flat">
                                    <input type="{{ $formtype ? 'password' : " text" }}" class="form-control" wire:model="password" placeholder="Votre mot de passe"
                                        autocomplete="off" />
                                    <span class="input-group-text">
                                        <span type='button' class="input-group-link" title="Afficher le mot de passe" wire:click="$toggle('formtype')">
                                            @if ($formtype)
                                            <i class="ti ti-eye"></i>
                                            @else
                                            <i class="ti ti-eye-off"></i>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" />
                                    <span class="form-check-label">Se souvenir de moi</span>
                                </label>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary w-100">Connexion</button>
                            </div>
                        </form>
                    </div>
                    <div class="hr-text">or</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-4 w-100">
                                    <i class="ti ti-brand-github"></i>
                                    Login with Github
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-4 w-100">
                                    <i class="ti ti-brand-x"></i>
                                    Login with X
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center text-secondary mt-3">Avez vous un compte ? <a href="./sign-up.html"
                        tabindex="-1">S'incrire</a></div>
            </div>
        </div>
        <div class="col-lg d-none d-lg-block">
            <svg class="img d-block mx-auto" xmlns="http://www.w3.org/2000/svg" height="400" fill="none"
                viewBox="0 0 800 600">
                <style>
                    :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-boy-with-key-a {
                        fill: black;
                        opacity: 0.07;
                    }

                    :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-boy-with-key-b {
                        fill: #454c5e;
                    }

                    :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-boy-with-key-c {
                        fill: #232b41;
                    }

                    :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-boy-with-key-d {
                        fill: #1a2030;
                    }

                    @media (prefers-color-scheme: dark) {
                        .tblr-illustrations-boy-with-key-a {
                            fill: black;
                            opacity: 0.07;
                        }

                        .tblr-illustrations-boy-with-key-b {
                            fill: #454c5e;
                        }

                        .tblr-illustrations-boy-with-key-c {
                            fill: #232b41;
                        }

                        .tblr-illustrations-boy-with-key-d {
                            fill: #1a2030;
                        }
                    }
                </style>
                <path
                    d="M186.938 250.28C186.938 282.917 221.448 306.586 236.694 332.944C252.426 360.117 256.201 401.692 283.389 417.41C309.747 432.656 347.26 415.608 379.897 415.608C412.534 415.608 450.047 432.656 476.405 417.41C503.578 401.678 507.368 360.132 523.1 332.944C538.346 306.586 572.856 282.888 572.856 250.28C572.856 217.672 538.346 193.974 523.1 167.616C507.368 140.443 503.593 98.8821 476.405 83.1502C450.047 67.9046 412.534 84.9665 379.897 84.9665C347.26 84.9665 309.747 67.9046 283.389 83.1502C256.216 98.8821 252.426 140.443 236.694 167.616C221.448 193.974 186.938 217.672 186.938 250.28Z"
                    fill="#F7F8FC" class="tblr-illustrations-boy-with-key-a" />
                <path
                    d="M416.324 311.42L435.288 373.475L436.532 458.67L449.289 461.016C456.468 429.199 463.643 397.378 470.813 365.552C466.484 343.241 462.146 320.935 457.799 298.634L395.586 296.875L368.642 351.222C371.941 376.011 375.249 400.768 378.567 425.49L389.908 423.531C392.34 402.822 394.761 382.109 397.174 361.39C435.311 320.859 452.903 298.615 449.947 294.658C448.002 291.979 436.794 297.566 416.324 311.42Z"
                    fill="#0455A4"
                    style="fill: #0455a4; fill: var(--tblr-illustrations-primary, var(--tblr-primary, #0455a4))" />
                <path
                    d="M454.666 485.958L433.757 475.818C433.757 475.818 434.73 469.354 438.749 468.353C442.767 467.352 452.779 478.936 454.666 485.958ZM380.784 456.497L394.199 436.117C394.199 436.117 390.394 431.068 386.476 432.441C382.557 433.814 379.196 449.374 380.784 456.497Z"
                    fill="#232B41" class="tblr-illustrations-boy-with-key-b" />
                <path
                    d="M389.908 423.502L397.174 361.362L422.917 333.173C420.524 325.135 418.14 317.088 415.766 309.032L390.995 305.957C383.53 321.031 376.069 336.109 368.613 351.193L378.538 425.462L389.908 423.502Z"
                    fill="black" opacity="0.15" />
                <path
                    d="M381.184 70.8794C380.393 67.7942 378.6 65.059 376.087 63.1023C373.574 61.1456 370.482 60.0782 367.297 60.0673H241.299C237.479 60.0673 233.816 61.5846 231.115 64.2855C228.415 66.9863 226.897 70.6495 226.897 74.4691V157.319C226.9 160.659 228.063 163.894 230.187 166.472L294.745 244.702C296.1 246.346 297.804 247.668 299.733 248.573C301.662 249.478 303.768 249.943 305.899 249.935C308.029 249.926 310.132 249.445 312.054 248.525C313.976 247.606 315.669 246.271 317.012 244.617L354.311 198.765L354.526 197.807L378.124 166.586C379.341 164.502 380.265 162.259 380.87 159.922C381.461 157.634 381.735 155.276 381.685 152.914V70.7793L381.184 70.8794Z"
                    fill="white" class="tblr-illustrations-boy-with-key-c" />
                <path
                    d="M305.8 253.798C303.096 253.803 300.425 253.207 297.979 252.055C295.533 250.902 293.373 249.222 291.656 247.134L227.14 168.918C224.43 165.632 222.944 161.507 222.936 157.247V74.4977C222.943 69.6335 224.879 64.9707 228.318 61.5312C231.758 58.0918 236.421 56.1561 241.285 56.1486H367.297C372.155 56.1637 376.809 58.1031 380.24 61.5422C383.671 64.9813 385.6 69.6398 385.604 74.4977H377.723C377.72 71.731 376.621 69.0784 374.667 67.1194C372.714 65.1605 370.064 64.0544 367.297 64.0431H241.299C238.528 64.0469 235.871 65.1496 233.911 67.1094C231.951 69.0692 230.848 71.7261 230.845 74.4977V157.319C230.846 159.745 231.69 162.096 233.233 163.969L297.791 242.185C298.764 243.37 299.986 244.325 301.37 244.983C302.755 245.64 304.267 245.984 305.8 245.99C307.349 245.987 308.878 245.639 310.276 244.971C311.674 244.303 312.905 243.332 313.88 242.128L351.165 196.277L357.286 201.254L320.102 247.034C318.393 249.143 316.236 250.845 313.787 252.015C311.337 253.186 308.658 253.795 305.943 253.798H305.8Z"
                    fill="#232B41" class="tblr-illustrations-boy-with-key-b" />
                <path
                    d="M328.468 115.329C328.472 110.829 327.222 106.417 324.858 102.588C322.493 98.7589 319.109 95.6645 315.084 93.6519C311.059 91.6394 306.553 90.7883 302.071 91.1942C297.59 91.6001 293.31 93.2469 289.712 95.9499C286.114 98.6528 283.341 102.305 281.703 106.496C280.065 110.688 279.628 115.253 280.44 119.679C281.253 124.105 283.282 128.217 286.302 131.554C289.321 134.891 293.21 137.32 297.533 138.569L284.018 170.805H324.392L310.934 138.584C315.984 137.134 320.425 134.082 323.588 129.887C326.751 125.692 328.464 120.583 328.468 115.329Z"
                    fill="#0455A4"
                    style="fill: #0455a4; fill: var(--tblr-illustrations-primary, var(--tblr-primary, #0455a4))" />
                <path
                    d="M419.427 98.8106V207.375C419.427 209.271 418.674 211.09 417.333 212.431C415.992 213.772 414.173 214.526 412.276 214.526H403.18C401.435 213.711 400.134 213.096 399.305 212.781C396.258 204.658 395.572 184.678 395.572 160.666C395.572 153.701 395.572 146.364 395.7 138.956C395.801 128.63 395.944 118.004 395.987 107.62V98.7677C395.987 96.8712 396.74 95.0523 398.081 93.7113C399.422 92.3702 401.241 91.6168 403.137 91.6168H412.233C413.18 91.6111 414.118 91.7933 414.993 92.1528C415.868 92.5123 416.664 93.042 417.333 93.7111C418.002 94.3803 418.532 95.1756 418.891 96.0509C419.251 96.9263 419.433 97.8643 419.427 98.8106Z"
                    fill="#FFCB9D" style="fill: #ffcb9d; fill: var(--tblr-illustrations-skin, #ffcb9d)" />
                <path
                    d="M419.427 107.663V130.675C416.293 132.052 413.037 133.134 409.702 133.907C405.104 134.974 400.39 135.454 395.672 135.337C395.729 130.751 395.782 126.151 395.829 121.536C395.829 116.902 395.929 112.268 395.958 107.692L419.427 107.663Z"
                    fill="black" opacity="0.1" />
                <path
                    d="M370.415 130.207L333.881 130.954L333.607 117.499L370.14 116.752L370.415 130.207ZM410.717 129.388L384.138 129.931L383.862 116.476L410.444 115.933L410.717 129.388ZM588.23 98.2957C585.489 87.5699 578.926 78.2136 569.776 71.9829C560.625 65.7522 549.515 63.0755 538.53 64.4554C527.546 65.8352 517.443 71.1766 510.117 79.4771C502.792 87.7775 498.748 98.4662 498.744 109.537V110.466C498.801 112.923 499.05 115.371 499.488 117.789C500.609 123.772 502.92 129.47 506.285 134.543C509.65 139.616 513.999 143.961 519.075 147.321C524.152 150.681 529.851 152.987 535.836 154.102C541.82 155.217 547.967 155.119 553.913 153.813C559.859 152.507 565.482 150.02 570.448 146.499C575.414 142.979 579.622 138.496 582.823 133.318C586.024 128.14 588.152 122.372 589.081 116.356C590.009 110.339 589.72 104.198 588.23 98.2957ZM567.779 132.191C563.736 136.402 558.641 139.454 553.021 141.031C547.401 142.608 541.461 142.653 535.818 141.16C530.175 139.667 525.035 136.691 520.93 132.542C516.825 128.392 513.905 123.219 512.474 117.56C511.873 115.169 511.546 112.717 511.501 110.252C511.405 105.955 512.158 101.682 513.717 97.6765C515.276 93.6715 517.611 90.0139 520.588 86.9136C523.564 83.8134 527.124 81.3317 531.062 79.6108C535.001 77.89 539.24 76.964 543.537 76.886C550.008 76.7447 556.376 78.5265 561.834 82.0059C567.291 85.4852 571.594 90.5056 574.197 96.4316C576.801 102.358 577.587 108.923 576.457 115.296C575.327 121.669 572.332 127.564 567.85 132.234L567.779 132.191Z"
                    fill="#A7AAB3" />
                <path
                    d="M544.109 105.833C544.1 105.358 543.997 104.889 543.807 104.453C543.616 104.018 543.342 103.624 542.999 103.295C542.657 102.966 542.252 102.707 541.81 102.534C541.367 102.361 540.895 102.276 540.419 102.286L512.159 102.858L499.202 103.13L460.73 103.916L448.56 104.174L412.433 104.903L394.07 105.275L307.573 107.048C305.685 107.132 303.902 107.94 302.596 109.306C301.289 110.671 300.56 112.488 300.56 114.378C300.56 116.268 301.289 118.085 302.596 119.45C303.902 120.816 305.685 121.624 307.573 121.708H307.874L328.039 121.307L370.158 120.42L383.901 120.134L397.259 119.863L409.873 119.62H410.488L448.231 118.862L461.102 118.604L499.459 117.818L512.431 117.546L540.677 116.974C541.639 116.951 542.554 116.549 543.221 115.855C543.888 115.161 544.253 114.232 544.238 113.27L544.109 105.833Z"
                    fill="#DADBE0" />
                <path
                    d="M399.276 212.824C399.367 213.091 399.472 213.354 399.591 213.61C399.065 213.263 398.564 212.88 398.089 212.466C398.132 212.395 398.518 212.509 399.276 212.824Z"
                    fill="#FFCB9D" style="fill: #ffcb9d; fill: var(--tblr-illustrations-skin, #ffcb9d)" />
                <path
                    d="M265.755 537.015C265.755 539.704 317.627 541.864 381.599 541.864C445.571 541.864 497.443 539.704 497.443 537.015C497.443 534.326 445.571 532.181 381.599 532.181C317.627 532.181 265.755 534.341 265.755 537.015Z"
                    fill="#A6A9B3" class="tblr-illustrations-boy-with-key-d" />
                <path
                    d="M466.465 240.741C464.349 252.854 462.389 264.138 463.905 278.64C464.989 288.834 467.577 298.81 471.585 308.245C460.015 312.189 448.009 314.715 435.831 315.768C417.596 317.326 399.228 315.607 381.599 310.691C387.915 299.066 392.355 286.516 394.756 273.506C397.903 256.487 396.373 242.5 395.143 230.258C394.957 228.513 394.771 226.84 394.571 225.209C393.527 216.843 392.139 209.892 390.995 204.786C392.799 201.774 395.24 199.192 398.146 197.221C402.662 194.274 408.009 192.864 413.392 193.202C413.206 194.632 413.048 195.948 412.862 197.321C413.884 196.851 414.929 196.436 415.994 196.077C417.034 195.7 418.094 195.385 419.169 195.133C420.902 194.68 422.666 194.355 424.447 194.16C422.588 201.769 425.877 209.02 431.598 211.479C431.886 211.608 432.182 211.718 432.484 211.808C435.887 212.779 439.532 212.422 442.682 210.807C441.251 214.883 442.267 216.07 442.567 216.356C444.155 217.872 448.774 216.356 454.18 212.28C454.511 211.954 454.812 211.6 455.081 211.222C456.514 209.164 457.292 206.722 457.312 204.214C457.655 204 457.999 203.799 458.342 203.628C463.448 197.55 471.099 197.564 473.959 200.768C476.062 203.17 475.947 207.775 473.602 211.851C470.53 221.297 468.145 230.952 466.465 240.741Z"
                    fill="#DADBE0" />
                <path
                    d="M414.736 111.139C414.718 112.718 414.326 114.272 413.593 115.671C412.86 117.07 411.806 118.277 410.517 119.191C410.325 119.345 410.125 119.488 409.916 119.62L397.302 119.863C395.783 118.99 394.501 117.757 393.57 116.273C392.519 114.606 392.004 112.657 392.093 110.688C392.183 108.72 392.873 106.826 394.07 105.261L412.434 104.889C413.913 106.636 414.728 108.849 414.736 111.139Z"
                    fill="black" opacity="0.1" />
                <path
                    d="M407.628 116.159C414.058 116.159 419.27 110.671 419.27 103.902C419.27 97.1328 414.058 91.6454 407.628 91.6454C401.199 91.6454 395.987 97.1328 395.987 103.902C395.987 110.671 401.199 116.159 407.628 116.159Z"
                    fill="#FFCB9D" style="fill: #ffcb9d; fill: var(--tblr-illustrations-skin, #ffcb9d)" />
                <path
                    d="M456.969 112.125C456.98 114.289 456.784 116.449 456.383 118.576L443.511 118.833C443.074 116.624 442.859 114.377 442.868 112.125C442.855 109.442 443.167 106.768 443.797 104.159L455.968 103.902C456.647 106.59 456.983 109.353 456.969 112.125Z"
                    fill="black" opacity="0.1" />
                <path
                    d="M460.902 91.6454H456.082C450.94 91.6454 446.772 95.8138 446.772 100.956V205.273C446.772 210.415 450.94 214.583 456.082 214.583H460.902C466.044 214.583 470.212 210.415 470.212 205.273V100.956C470.212 95.8138 466.044 91.6454 460.902 91.6454Z"
                    fill="#FFCB9D" style="fill: #ffcb9d; fill: var(--tblr-illustrations-skin, #ffcb9d)" />
                <path
                    d="M439.092 136.324C438.368 135.873 437.526 135.649 436.673 135.679C435.821 135.709 434.997 135.993 434.306 136.494C433.616 136.995 433.09 137.69 432.797 138.491C432.503 139.292 432.455 140.162 432.659 140.991C432.862 141.819 433.308 142.568 433.939 143.142C434.571 143.716 435.358 144.088 436.202 144.212C437.046 144.336 437.908 144.205 438.678 143.837C439.447 143.469 440.089 142.88 440.522 142.145C441.091 141.18 441.259 140.031 440.992 138.943C440.725 137.856 440.043 136.916 439.092 136.324ZM452.822 104.689C448.483 113.27 444.155 121.808 439.836 130.303L444.412 133.163L459.615 109.98L452.822 104.689ZM455.081 149.095C455.701 148.788 456.368 148.589 457.055 148.509C457.648 148.43 458.249 148.43 458.843 148.509C459.395 148.581 459.941 148.701 460.473 148.867L461.903 149.31C462.34 149.44 462.792 149.517 463.248 149.539C463.67 149.564 464.092 149.486 464.478 149.31C464.765 149.173 465.019 148.974 465.219 148.726C465.42 148.479 465.562 148.19 465.636 147.88C465.786 147.217 465.694 146.522 465.379 145.92C465.052 145.219 464.518 144.635 463.848 144.247C463.136 143.849 462.334 143.637 461.517 143.632L462.118 138.426C463.837 138.462 465.516 138.956 466.98 139.857C468.59 140.898 469.858 142.39 470.627 144.147C471.251 145.385 471.612 146.739 471.686 148.123C471.759 149.332 471.475 150.535 470.87 151.584C470.193 152.682 469.195 153.546 468.01 154.058C467.28 154.417 466.498 154.658 465.693 154.773C465.025 154.881 464.344 154.881 463.677 154.773C463.047 154.645 462.461 154.487 461.889 154.316L460.259 153.786C459.773 153.623 459.268 153.522 458.757 153.486C458.261 153.471 457.77 153.579 457.327 153.801L455.081 149.095ZM447.845 155.474C447.644 155.062 447.539 154.61 447.539 154.151C447.539 153.693 447.644 153.24 447.845 152.828C448.221 151.948 448.915 151.243 449.79 150.855C450.633 150.419 451.612 150.327 452.521 150.597C452.962 150.722 453.369 150.943 453.712 151.245C454.056 151.547 454.329 151.921 454.509 152.342C454.721 152.75 454.84 153.2 454.86 153.659C454.88 154.119 454.799 154.577 454.624 155.002C454.253 155.877 453.562 156.578 452.693 156.961C451.841 157.382 450.865 157.478 449.947 157.233C449.485 157.121 449.055 156.905 448.69 156.6C448.325 156.294 448.036 155.909 447.845 155.474Z"
                    fill="#0455A4"
                    style="fill: #0455a4; fill: var(--tblr-illustrations-primary, var(--tblr-primary, #0455a4))" />
                <path
                    d="M432.527 211.823L393.913 277.954C395.601 269.386 396.52 260.685 396.659 251.953C396.81 243 396.13 234.051 394.628 225.223C393.584 216.857 392.196 209.906 391.052 204.801C392.857 201.788 395.297 199.206 398.203 197.235C402.719 194.288 408.067 192.878 413.449 193.216C413.263 194.646 413.106 195.962 412.92 197.335C413.941 196.865 414.986 196.45 416.052 196.091C417.091 195.715 418.151 195.399 419.227 195.147C420.96 194.694 422.723 194.369 424.504 194.174C427.183 200.057 429.858 205.94 432.527 211.823Z"
                    fill="black" opacity="0.1" />
                <path
                    d="M471.857 202.884C471.028 206.474 466.423 207.275 460.802 208.533C456.746 209.287 452.83 210.656 449.189 212.595C447.25 213.706 445.494 215.11 443.983 216.757C440.25 220.847 440.05 224.38 435.216 226.611C431.812 228.083 428.005 228.341 424.433 227.34C415.036 224.666 409.087 213.038 410.002 202.87C410.115 201.554 410.35 200.252 410.703 198.98L419.542 193.559C419.928 201.454 424.204 208.262 430.568 211.05C434.819 212.85 439.568 213.098 443.983 211.751C446.447 211.017 448.612 209.513 450.161 207.461C451.605 205.402 452.388 202.953 452.407 200.439L464.964 199.852L471.514 199.552C471.977 200.599 472.097 201.765 471.857 202.884Z"
                    fill="#FFCB9D" style="fill: #ffcb9d; fill: var(--tblr-illustrations-skin, #ffcb9d)" />
                <path
                    d="M430.554 211.065C429.758 210.72 428.992 210.309 428.266 209.835H410.388C411.947 217.801 417.139 225.281 424.418 227.354C427.99 228.355 431.797 228.097 435.202 226.625C439.178 224.794 440.022 222.063 442.353 218.874V212.223C438.394 213.046 434.277 212.642 430.554 211.065Z"
                    fill="black" opacity="0.1" />
                <path
                    d="M433.714 158.52C435.145 161.381 437.347 165.442 439.821 170.591C440.35 171.735 440.822 172.722 440.994 173.065C443.526 178.804 445.323 184.839 446.343 191.028C446.529 192.258 446.672 193.445 446.758 194.632C447.058 199.037 436.746 210.621 424.99 215.884C413.234 221.147 402.951 212.752 404.968 205.344C405.55 202.519 405.613 199.611 405.154 196.763C404.679 192.9 403.924 189.076 402.894 185.322C402.365 183.162 401.922 181.789 401.922 181.789L406.212 169.175L427.064 156.918C428.88 160.58 431.226 162.468 432.456 162.038C433.686 161.609 433.714 159.078 433.714 158.52Z"
                    fill="#FFCB9D" style="fill: #ffcb9d; fill: var(--tblr-illustrations-skin, #ffcb9d)" />
                <path
                    d="M433.715 158.52C435.145 161.381 437.347 165.442 439.821 170.591C440.351 171.735 440.822 172.722 440.994 173.065C443.526 178.804 445.324 184.839 446.343 191.028C444.743 191.396 443.088 191.454 441.466 191.2C439.688 190.893 437.988 190.242 436.46 189.283C434.865 188.23 433.446 186.932 432.256 185.436C431.429 184.532 430.66 183.577 429.953 182.576C423.521 189.934 414.811 194.928 405.211 196.763C404.736 192.9 403.981 189.076 402.952 185.322C402.422 183.162 401.979 181.789 401.979 181.789L406.27 169.175L427.121 156.918C428.938 160.58 431.283 162.468 432.513 162.038C433.743 161.609 433.715 159.078 433.715 158.52Z"
                    fill="black" opacity="0.1" />
                <path
                    d="M388.121 186.852C389.605 187.888 391.191 188.769 392.854 189.483C394.974 190.437 397.218 191.087 399.519 191.414C409.888 192.844 421.057 186.723 427.722 175.682C428.831 173.803 429.788 171.837 430.582 169.804C430.582 169.804 430.582 169.804 430.668 169.804C431.398 170.903 432.044 172.055 432.599 173.251C432.828 173.809 432.928 173.966 433.071 174.309L433.214 174.696C434.05 177.413 435.127 180.05 436.432 182.576C437.44 184.066 438.891 185.202 440.579 185.822C439.705 183.282 439.479 180.563 439.921 177.913C440.142 176.943 440.423 175.988 440.765 175.053C442.021 170.097 441.42 164.852 439.078 160.308C438.094 158.457 436.83 156.768 435.331 155.302C434.358 154.33 430.826 150.812 426.864 150.068C418.712 148.523 407.228 158.649 402.122 164.498C401.045 166.021 399.557 167.207 397.831 167.917C397.464 168.017 397.08 168.046 396.702 168.002C394.256 167.773 392.411 164.942 391.839 162.825C390.666 158.72 393.055 153.801 397.789 150.211C385.303 154.087 378.281 165.485 380.183 175.325C381.202 180.065 384.056 184.209 388.121 186.852Z"
                    fill="#232B41" class="tblr-illustrations-boy-with-key-b" />
                <path
                    d="M388.121 186.852C389.605 187.888 391.191 188.77 392.854 189.484C394.974 190.437 397.218 191.087 399.519 191.414C409.888 192.844 421.057 186.723 427.722 175.682C429.152 172.722 430.425 170.19 430.582 169.804L432.156 164.956C428.369 170.672 423.576 175.653 418.011 179.658C413.077 183.191 406.241 188.125 396.716 188.239C393.798 188.199 390.903 187.732 388.121 186.852Z"
                    fill="black" opacity="0.5" />
                <path
                    d="M474.875 207.375C476.027 202.631 476.821 197.807 477.249 192.944C474.102 193.07 470.955 192.699 467.924 191.843C462.99 190.413 460.959 188.439 456.411 186.537C452.341 184.874 448.006 183.949 443.611 183.806C443.311 187.839 442.739 193.645 441.609 200.61C440.479 207.575 439.907 211.022 438.32 214.697C435.765 220.409 431.774 225.361 426.735 229.071L469.483 223.45C471.737 218.256 473.541 212.878 474.875 207.375Z"
                    fill="#DADBE0" />
            </svg>
        </div>
    </div>
</div>
