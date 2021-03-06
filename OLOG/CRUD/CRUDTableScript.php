<?php

namespace OLOG\CRUD;

class CRUDTableScript
{
	public static function render($table_class, $query_url)
	{
		static $include_script;

		if (!isset($include_script)) {
			$include_script = false;

			echo \OLOG\Preloader::preloaderJsHtml();
			?>
			<script>
				var CRUD = CRUD || {};

				CRUD.Table = CRUD.Table || {

						init: function (table_class, query_url) {
							CRUD.Table.clickTableRow(table_class);
							CRUD.Table.filterAjaxLoad(table_class, query_url);
							CRUD.Table.paginationAjaxLoad(table_class, query_url);
						},

						clickTableRow: function (table_class) {
							var table_elem_selector = '.' + table_class + ' .table';
							$(table_elem_selector).each(function () {
								$(this).find("tbody tr").each(function () {
									var $tr = $(this);
									// Проверка на наличие ссылки
									if ($tr.find("a").length == 0) {
										return false;
									}
									// Проверка на наличие только одной ссылки
									if ($tr.find("a").length > 1) {
										return false;
									}
									var $link = $tr.find("a:first");
									var url = $link.attr("href");
									var link_style = "z-index: 1;position: absolute;top: 0;bottom: 0;left: 0;right: 0;display: block;";
									$tr.find("td").each(function () {
										var $td = $(this).attr("style", "position: relative;");
										var $childrenTag = $td.find(">*");
										if ($childrenTag[0] && $childrenTag[0].tagName == "FORM") {
											return false;
										}
										$td.prepend('<a href="' + url + '" style="' + link_style + '"></a>');
									});
								});
							});
						},

						filterAjaxLoad: function (table_class, query_url) {
							var filter_elem_selector = '.' + table_class + ' .filters-form';
							var pagination_elem_selector = '.' + table_class + ' .pagination';
							$(filter_elem_selector).on('submit', function (e) {
								e.preventDefault();
								e.stopPropagation(); // for a case when filters form is within another form (model creation form for example)
								var params = $(this).serialize();
								$(this).data('params', params);
								var filters = $(this).data('params') || '';
								var pagination = $(pagination_elem_selector).data('params') || '';
								var query = query_url + '?' + filters + '&' + pagination;
								CRUD.Table.requestAjax(table_class, query);
							});
						},

						paginationAjaxLoad: function (table_class, query_url) {
							var filter_elem_selector = '.' + table_class + ' .filters-form';
							var pagination_elem_selector = '.' + table_class + ' .pagination';
							$(pagination_elem_selector).on('click', 'a', function (e) {
								e.preventDefault();
								if ($(this).attr('href') == "#") {
									return false;
								}
								var params = $(this).attr('href').split('?')[1];
								$(this).data('params', params);
								var filters = $(filter_elem_selector).data('params') || '';
								var pagination = $(this).data('params') || '';
								var query = query_url + '?' + filters + '&' + pagination;
								CRUD.Table.requestAjax(table_class, query);
							});
						},

						requestAjax: function (table_class, query) {
							var table_elem_selector = '.' + table_class + ' .table';
							var pagination_elem_selector = '.' + table_class + ' .pagination';

							OLOG.preloader.show();

							$.ajax({
								url: query
							}).success(function (received_html) {
								OLOG.preloader.hide();
								var $box = $('<div>', {html: received_html});

								$(table_elem_selector).html($box.find(table_elem_selector).html());
								$(pagination_elem_selector).html($box.find(pagination_elem_selector).html());

								CRUD.Table.clickTableRow(table_class);
							}).fail(function () {
								OLOG.preloader.hide();
							});
						}

					};
			</script>
			<?php
		}

		?>
		<script>
			CRUD.Table.init('<?= $table_class ?>', '<?= $query_url ?>');
		</script>
		<?php
	}

	public static function getHtml($table_class, $query_url)
	{
		ob_start();
		self::render($table_class, $query_url);
		return ob_get_clean();
	}
}