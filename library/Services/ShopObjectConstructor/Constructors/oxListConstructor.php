<?php
/**
 * This file is part of OXID eSales Testing Library.
 *
 * OXID eSales Testing Library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales Testing Library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales Testing Library. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2014
 */

/**
 * Class oxConfigCaller
 */
class oxListConstructor extends ObjectConstructor
{
    /**
     * Skip loading of config object, as it is already loaded
     *
     * @param $sOxId
     */
    public function load($sOxId) {
        $this->getObject()->init($sOxId, $sOxId);
    }

    /**
     * Calls object function with given parameters
     *
     * @param $sFunction
     * @param $aParameters
     * @return mixed
     */
    public function callFunction($sFunction, $aParameters)
    {
        if ($sFunction == 'getList') {
            $oObject = $this->getObject();
            $mResponse = $this->_formArrayFromList($oObject->getList());
        } else {
            $mResponse = parent::callFunction($sFunction, $aParameters);
        }

        return $mResponse;
    }

    /**
     * Returns formed array with data from given list
     *
     * @param $oList
     * @return array
     */
    protected function _formArrayFromList($oList)
    {
        $aData = array();
        foreach ($oList as $sKey => $oObject) {
            $aData[$sKey] = $this->_getObjectFieldValues($oObject);
        }

        return $aData;
    }

    /**
     * Returns object field values
     *
     * @param object $oObject
     * @return array
     */
    protected function _getObjectFieldValues($oObject)
    {
        $aData = array();
        $aFields = $oObject->getFieldNames();
        $sTableName = $oObject->getCoreTableName();
        foreach ($aFields as $sField) {
            $sFieldName = $sTableName.'__'.$sField;
            $aData[$sField] = $oObject->$sFieldName->value;
        }

        return $aData;
    }
}
