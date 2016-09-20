<?php

namespace OLOG\CRUD;

use OLOG\Sanitize;

class CRUDFormWidgetMediumEditor implements InterfaceCRUDFormWidget
{
	protected $field_name;
    protected $uniqid;

	public function __construct($field_name, $uniqid = '')
	{
		$this->setFieldName($field_name);
        if ($uniqid) {
            $this->setUniqid($uniqid);
        } else {
            $this->setUniqid(uniqid('CRUDFormWidgetMediumEditor_'));
        }
	}

	public function html($obj)
	{
		static $CRUDFormWidgetMediumEditor_include_script;

		$field_name = $this->getFieldName();
		$field_value = CRUDFieldsAccess::getObjectFieldValue($obj, $field_name);

		/* Нужно изменить на нах CDN */
		$script = '';
		$uniqid = $this->getUniqid();
		if (!isset($CRUDFormWidgetMediumEditor_include_script)) {
			$script = '
				<script src="//cdnjs.cloudflare.com/ajax/libs/medium-editor/5.22.0/js/medium-editor.min.js"></script>
				<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/medium-editor/5.22.0/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
				<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/medium-editor/5.22.0/css/themes/default.min.css" type="text/css" media="screen" charset="utf-8">			';
			$CRUDFormWidgetMediumEditor_include_script = false;
		}

		$html = '';

		$html .= '<textarea id="' . $uniqid . '_textarea" name="' . Sanitize::sanitizeAttrValue($field_name) . '" style="display: none;">' . $field_value . '</textarea>';
		$html .= '<div id="' . $uniqid . '" class="form-control" style="height: auto;">' . $field_value . '</div>';
        ob_start();?>
			<script>
				var <?= $uniqid ?> = new MediumEditor("#<?= $uniqid ?>", {
					placeholder: false
				});

                <?= $uniqid ?>.subscribe('editableInput', function (event, editable) {
					var content = $(editable).html();
					$('#<?= $uniqid ?>_textarea').val(content).trigger('MediumEditor.change');
				});
			</script>
		<?php
        $html .= ob_get_clean();

		return $script . $html;
	}

	/**
	 * @return mixed
	 */
	public function getFieldName()
	{
		return $this->field_name;
	}

	/**
	 * @param mixed $field_name
	 */
	public function setFieldName($field_name)
	{
		$this->field_name = $field_name;
	}

    /**
     * @return mixed
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * @param mixed $uniqid
     */
    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;
    }

}