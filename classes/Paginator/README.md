PaginatorHelper
==================

## 说明

    1. 这个辅助类是用于Slim framework 2的一个分页器，功能相对比较粗糙。
    2. 分页样式使用Bootstrap分页样式

    使用例子:

    ```php
        // 每页的显示的条数
        define('PAGE_SIZE', 20);

        // 当前页码
        $page = 2;
        // 获取数据总数
        $totalnum = 200;
        // 获取分页数据
        $start = ($page - 1) * PAGE_SIZE;
        $end = PAGE_SIZE;

        $app = \Slim\Slim\App::getInstance();

        $route_name = 'route.name';

        // 设置分页
        $paginater = new Paginater($app, $route_name, $page, $totalnum);
        $paginater_html = $paginater->getPaginate();
    ```
