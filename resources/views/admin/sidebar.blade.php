<div id="sidebar" class="sidebar" data-color="blue" data-image="{{ asset('assets/img/sidebar-5.jpg') }}">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text">MauMau Painel</a>
        </div>
        <ul class="nav">
            <li @if(Request::route()->getName() == 'admin.dashboard') class="active" @endif>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="pe-7s-graph"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li @if(Request::route()->getName() == 'admin.cartas') class="active" @endif>
                <a href="{{ route('admin.cartas') }}">
                    <i class="pe-7s-albums"></i>
                    <p>Cartas</p>
                </a>
            </li>
            <li @if(Request::route()->getName() == 'admin.baralhos-e-naipes') class="active" @endif>
                <a href="{{ route('admin.baralhos-e-naipes') }}">
                    <i class="pe-7s-note2"></i>
                    <p>Baralhos e Naipes</p>
                </a>
            </li>
            <li @if(Request::route()->getName() == 'admin.modalidades') class="active" @endif>
                <a href="{{ route('admin.modalidades') }}">
                    <i class="pe-7s-science"></i>
                    <p>Modalidades</p>
                </a>
            </li>
        </ul>
    </div>
</div>