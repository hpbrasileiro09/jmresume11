<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">
              <span data-feather="sidebar"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('entry.index') }}">
              <span data-feather="dollar-sign"></span>
              Entry
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('time.index') }}">
              <span data-feather="calendar"></span>
              Time
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('entry.support') }}">
              <span data-feather="tool"></span>
              Support
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('reports.detalhe') }}">
              <span data-feather="archive"></span>
              Report
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('param.edit', 1) }}">
              <span data-feather="settings"></span>
              Param
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('payments.index') }}">
              <span data-feather="box"></span>
              Payments
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cards.index') }}">
              <span data-feather="credit-card"></span>
              Cards
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('tools.index') }}">
              <span data-feather="codesandbox"></span>
              Tools
            </a>
          </li>
        </ul>

      </div>
    </nav>