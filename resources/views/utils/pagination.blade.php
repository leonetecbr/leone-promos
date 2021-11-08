@if (!(empty($page) || empty($final) || empty($group_name)) && $final!=1)
<?php $route = ($group_name != 1)?route(Request::route()->getName(), $group_name): route(Request::route()->getName()); ?>
<div class="text-muted container mb-2">Página {{ $page }} de {{ $final }} </div>
<nav>
  <ul class="pagination justify-content-center">
    <li class="page-item {{ ($page==1)?'disabled':''; }}">
      <a class="page-link" href="{{ $page-1 }}" aria-label="Anterior">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Anterior</span>
      </a>
    </li>
    @for ($i = 0; $i < 3; $i++)
    <?php 
    $loop_page = ($page == 1)?$page+$i:$page+$i-1;
    $loop_page = ($page==$final && $final>=3)?$page+$i-2:$loop_page;
    ?>
    <li class="page-item{{ ($loop_page==$page)?' active':''; }}"><a class="page-link" href="{{ $route.'/'.$loop_page }}">{{ $loop_page }}</a></li>
    @endfor
    <li class="page-item {{ ($page==$final)?'disabled':''; }}">
      <a class="page-link" href="{{ $route.'/'.($page+1) }}" aria-label="Próximo">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Próximo</span>
      </a>
    </li>
  </ul>
</nav>
@endif