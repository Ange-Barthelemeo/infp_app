<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion - INFP Madagascar</title>
        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <style>
            body {
                background-color: #f8f9fa;
                font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
                margin: 0;
                padding: 0;
            }
            /* Ligne de couleur du drapeau en haut de l'écran */
            .flag-top-bar {
                height: 6px;
                display: flex;
                width: 100%;
            }
            .flag-red { background-color: #fc3d21; flex: 1; }
            .flag-white { background-color: #ffffff; flex: 1; }
            .flag-green { background-color: #007e3a; flex: 1; }

            .login-card {
                max-width: 440px;
                border: none;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.06);
                overflow: hidden;
                background: #ffffff;
                transition: all 0.3s ease-in-out;
            }
            .login-header {
                background-color: #007e3a;
                color: white;
                padding: 22px 20px;
                text-align: center;
            }
            /* Bouton d'action */
            .btn-success-custom {
                background-color: #007e3a;
                border: none;
                padding: 10px 16px;
                font-weight: 500;
            }
            .btn-success-custom:hover {
                background-color: #056631;
            }
            /* Labels en noir */
            .form-label {
                color: #000000 !important;
                font-weight: 600;
                font-size: 0.85rem;
            }
            /* Sous-titre CRFRP */
            .subtitle-crfrp {
                font-size: 0.7rem;
                letter-spacing: 0.8px;
                color: #6c757d;
            }
            /* Alerte d'erreur personnalisée */
            .alert-custom-error {
                background-color: #fff5f5;
                border: 1px solid #f8d7da;
                color: #dc3545;
                border-radius: 8px;
                padding: 10px 14px;
                font-size: 0.85rem;
                font-weight: 500;
                transition: opacity 0.4s ease, margin 0.4s ease, padding 0.4s ease;
            }
            /* Drapeau miniature */
            .malagasy-flag {
                width: 52px;
                height: 34px;
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.15);
                display: flex;
                overflow: hidden;
                margin: 0 auto 8px auto;
            }
            .flag-vertical-stripe {
                width: 35%;
                height: 100%;
                background-color: #ffffff;
            }
            .flag-horizontal-stripes {
                width: 65%;
                height: 100%;
                display: flex;
                flex-direction: column;
            }
            .flag-stripe-red {
                height: 50%;
                background-color: #fc3d21;
            }
            .flag-stripe-green {
                height: 50%;
                background-color: #007e3a;
            }

            /* Contour vert au focus */
            .form-control:focus {
                border-color: #007e3a !important;
                box-shadow: 0 0 0 0.2rem rgba(0, 126, 58, 0.15) !important;
            }

            /* Œil intégré à l'input mot de passe */
            .password-container {
                position: relative;
            }
            .password-container .form-control {
                padding-right: 40px;
            }
            .password-toggle-icon {
                position: absolute;
                top: 50%;
                right: 12px;
                transform: translateY(-50%);
                cursor: pointer;
                color: #6c757d;
                z-index: 10;
            }
            .password-toggle-icon:hover {
                color: #007e3a;
            }
        </style>
    </head>
    <body>

        <!-- Barre supérieure aux couleurs du drapeau -->
        <div class="flag-top-bar">
            <div class="flag-white"></div>
            <div class="flag-red"></div>
            <div class="flag-green"></div>
        </div>

        <div class="container d-flex flex-column align-items-center justify-content-center py-5" style="min-height: 95vh;">
            
            <!-- En-tête institutionnel -->
            <div class="text-center mb-4">
                <div class="malagasy-flag">
                    <div class="flag-vertical-stripe"></div>
                    <div class="flag-horizontal-stripes">
                        <div class="flag-stripe-red"></div>
                        <div class="flag-stripe-green"></div>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1" style="font-size: 1.5rem;">INFP Madagascar</h3>
                <p class="text-uppercase mb-0 subtitle-crfrp">SYSTÈME DE GESTION CRFRP</p>
            </div>

            <!-- Carte de Connexion Principale -->
            <div class="card login-card w-100">
                <div class="login-header">
                    <h4 class="fw-bold mb-1" style="font-size: 1.1rem;">Connexion sécurisée</h4>
                    <p class="mb-0 small text-white-50" style="font-size: 0.8rem;">Accès réservé au personnel autorisé</p>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('login/attempt') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <!-- MESSAGE D'ERREUR EN HAUT DU FORMULAIRE -->
                        <?php if(session()->getFlashdata('error')): ?>
                            <div id="loginErrorAlert" class="alert-custom-error mb-3 d-flex align-items-center">
                                <i class="bi bi-circle-fill text-danger me-2" style="font-size: 7px;"></i> 
                                <span><?= session()->getFlashdata('error') ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="immutilisateur" class="form-label">Matricule (IMMUTILISATEUR)</label>
                            <input type="text" class="form-control py-2" id="immutilisateur" name="immutilisateur" placeholder="ADM-001" value="<?= old('immutilisateur') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="motdepasse" class="form-label">Mot de passe</label>
                            <div class="password-container">
                                <input type="password" class="form-control py-2" id="motdepasse" name="motdepasse" placeholder="••••••••">
                                <i class="bi bi-eye-slash password-toggle-icon" id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success-custom text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Scripts JavaScript -->
        <script>
            // Basculer l'affichage du mot de passe
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('motdepasse');

            if (togglePassword) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    this.classList.toggle('bi-eye');
                    this.classList.toggle('bi-eye-slash');
                });
            }

            // Disparition du message d'erreur et redimensionnement dynamique de la carte après 5s
            window.addEventListener('DOMContentLoaded', () => {
                const loginErrorAlert = document.getElementById('loginErrorAlert');
                if (loginErrorAlert) {
                    setTimeout(() => {
                        loginErrorAlert.style.opacity = '0';
                        setTimeout(() => {
                            loginErrorAlert.remove(); // Supprime complètement l'élément du DOM pour ajuster la hauteur de la carte
                        }, 400);
                    }, 5000);
                }
            });
        </script>
    </body>
</html>