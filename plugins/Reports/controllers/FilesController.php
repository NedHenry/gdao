<?php
/**
 * @package Reports
 * @subpackage Controllers
 * @copyright Copyright (c) 2011 Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */
 
/**
 * Index controller
 *
 * @package Reports
 * @subpackage Controllers
 */
class Reports_FilesController extends Omeka_Controller_Action
{
    /**
     * Sets the model class for the files controller.
     */
    public function init()
    {
        if (version_compare(OMEKA_VERSION, '2.0-dev', '>=')) {
            $this->_helper->db->setDefaultModelName('Reports_File');
        } else {
            $this->_modelClass = 'Reports_File';
        }
    }

    public function showAction()
    {
        $file = $this->findById();
        $storage = $this->getInvokeArg('bootstrap')->storage;
        $prefix = reports_get_storage_prefix();
        $uri = $storage->getUri("$prefix{$file->filename}");
        return $this->_helper->redirector->gotoUrl($uri);
    }
    
    /**
     * Deletes a Reports_File instance and deletes the underlying file.
     */
    public function deleteAction()
    {
        $reportFile = $this->findById();
        $report = $reportFile->getReport();
        $reportFile->delete();
        $this->redirect->gotoRoute(
            array(
                'module' => 'reports',
                'controller' => 'index',
                'id' => $report->id,
                'action' => 'show',
            ),
            'default'
        );
    }
}
