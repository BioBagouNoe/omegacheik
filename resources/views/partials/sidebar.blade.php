  <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
          <div class="logo">OMEGACHEIK</div>
          <h2>Gestion Parc Auto</h2>
      </div>

      <nav class="sidebar-nav">
          <!-- Section Profil -->
          <div class="profile-section">
              <a href="{{ route('profile') }}" class="nav-item">
                  <i class="fas fa-user-circle"></i>
                  Mon Profil
              </a>
          </div>

          <div class="nav-section" id="gestion-parc">
              <div class="nav-section-title">Gestion du Parc</div>
              <a href="{{ route('dashboard') }}" class="nav-item active">
                  <i class="fas fa-chart-pie"></i>
                  Dashboard
              </a>
              <a href="{{ route('lines') }}" class="nav-item">
                  <i class="fas fa-route"></i>
                  Ligne
              </a>
              <a href="{{ route('agencies') }}" class="nav-item">
                  <i class="fas fa-building"></i>
                  Agence
              </a>
              <a href="{{ route('ships') }}" class="nav-item">
                  <i class="fas fa-ship"></i>
                  Navire
              </a>
              <a href="{{ route('manifests') }}" class="nav-item">
                  <i class="fas fa-file-contract"></i>
                  Manifeste
              </a>

              <a href="#" class="nav-item">
                  <i class="fas fa-users"></i>
                  Utilisateur
              </a>
          </div>

          <!-- Section Notifications -->
          <div class="notifications-section">
              <a href="#notifications" class="notification-item">
                  <div style="display: flex; align-items: center;">
                      <i class="fas fa-bell"></i>
                      <span>Notifications</span>
                  </div>
                  <span class="notification-badge-sidebar">7</span>
              </a>
          </div>

          <div class="nav-section" id="deconnexion">
              <a href="#" class="nav-item" onclick="alert('Déconnexion en cours...');">
                  <i class="fas fa-sign-out-alt"></i>
                  Déconnexion
              </a>
          </div>
      </nav>

      <div class="user-profile">
          <div class="user-info">
              <div class="user-avatar">JD</div>
              <div class="user-details">
                  <h4>John Doe</h4>
                  <p id="user-role">Administrateur</p>
              </div>
          </div>
      </div>
  </aside>