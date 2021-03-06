<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 * @access private
 */
 
/**
 * @internal This implements Omeka internals and is not part of the public API.
 * @access private
 * @package Omeka
 * @subpackage Models
 * @author CHNM
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 */
class RecordTypeTable extends Omeka_Db_Table
{
    protected $_alias = 'rty';
    
    public function findIdFromName($recordTypeName)
    {
        $select = $this->getSelect()->reset(Zend_Db_Select::COLUMNS);
        $select->from(array(), 'id')->where('name = ?', (string) $recordTypeName);
        return $this->getDb()->fetchOne($select);
    }
}
