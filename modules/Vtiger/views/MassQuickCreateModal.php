<?php
/**
 * Mass quick create modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

/**
 * Mass quick create modal view class.
 */
class Vtiger_MassQuickCreateModal_View extends Vtiger_QuickCreateAjax_View
{
	/** {@inheritdoc} */
	public $fromView = 'MassQuickCreate';

	/** {@inheritdoc} */
	public function loadFieldValuesFromSource(App\Request $request): array
	{
		$fieldValues = parent::loadFieldValuesFromSource($request);
		if ($request->has('multiSaveField')) {
			$this->hiddenInput['multiSaveField'] = $request->getByType('multiSaveField', 'Alnum');
		} elseif ($relatedField = \App\Field::getRelatedFieldForModule($request->getModule(), $request->getByType('sourceModule', 'Alnum'))) {
			$this->hiddenInput['multiSaveField'] = $relatedField['fieldname'];
		}
		if (isset($fieldValues[$this->hiddenInput['multiSaveField']])) {
			unset($fieldValues[$this->hiddenInput['multiSaveField']]);
		}
		if (isset($this->recordStructure[$this->hiddenInput['multiSaveField']])) {
			unset($this->recordStructure[$this->hiddenInput['multiSaveField']]);
		}
		$this->hiddenInput['sourceView'] = $request->getByType('sourceView');
		$this->hiddenInput['sourceModule'] = $request->getByType('sourceModule', 'Alnum');
		$this->hiddenInput['entityState'] = $request->getByType('entityState', 'Alnum');
		$this->hiddenInput['search_params'] = \App\Json::encode($request->getArray('search_params'));
		$this->hiddenInput['excluded_ids'] = \App\Json::encode($request->getArray('excluded_ids', 'Integer'));
		$this->hiddenInput['selected_ids'] = \App\Json::encode($request->getArray('selected_ids', 'Alnum'));
		if ('ListView' === $this->hiddenInput['sourceView']) {
			$this->hiddenInput['viewname'] = $request->getByType('viewname', 'Alnum');
		} elseif ('RelatedListView' === $this->hiddenInput['sourceView']) {
			$this->hiddenInput['relationId'] = $request->getInteger('relationId');
			$this->hiddenInput['relatedRecord'] = $request->getInteger('relatedRecord');
			$this->hiddenInput['relatedModule'] = $request->getByType('relatedModule', 'Alnum');
		}
		return $fieldValues;
	}
}
