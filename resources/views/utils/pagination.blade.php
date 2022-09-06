@if (!(empty($page) || empty($endPage) || empty($groupName)) && $endPage!=1)
        <?php $route = ($groupName != 1) ? route(Request::route()->getName(), $groupName) : route(Request::route()->getName()); ?>
    <div class="text-muted container mb-2">Página {{ $page }} de {{ $endPage }} </div>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item {{ ($page==1)?'disabled':''; }}">
                <a class="page-link" href="{{ $page-1 }}" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Anterior</span>
                </a>
            </li>
                <?php $ate = ($endPage >= 3) ? 3 : $endPage; ?>
            @for ($i = 0; $i < $ate; $i++)
                    <?php
                    $loopPage = ($page == 1) ? $page + $i : $page + $i - 1;
                    $loopPage = ($page == $endPage && $endPage >= 3) ? $page + $i - 2 : $loopPage;
                    ?>
                <li class="page-item{{ ($loopPage==$page)?' active':''; }}">
                    <a class="page-link" href="{{ $route.'/'.$loopPage }}">{{ $loopPage }}</a>
                </li>
            @endfor
            <li class="page-item {{ ($page==$endPage)?'disabled':''; }}">
                <a class="page-link" href="{{ $route.'/'.($page+1) }}" aria-label="Próximo">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Próximo</span>
                </a>
            </li>
        </ul>
    </nav>
@endif
