<?php
/**
 * Shopware 4
 * Copyright © shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace ShopwarePlugins\SwagUpdate\Components\Checks;

use ShopwarePlugins\SwagUpdate\Components\CheckInterface;
use Enlight_Components_Snippet_Namespace as SnippetNamespace;
use ShopwarePlugins\SwagUpdate\Components\Validation;

/**
 * @category  Shopware
 * @package   ShopwarePlugins\SwagUpdate\Components\Checks
 * @copyright Copyright (c) shopware AG (http://www.shopware.com)
 */
class PHPExtensionCheck implements CheckInterface
{
    const CHECK_TYPE = 'phpextension';

    /**
     * @var SnippetNamespace
     */
    private $namespace;

    /**
     * @param SnippetNamespace $namespace
     */
    public function __construct(SnippetNamespace $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandle($requirement)
    {
        return $requirement['type'] == self::CHECK_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function check($requirement)
    {
        $requiredExtesion = $requirement['value'];

        $successMessage = $this->namespace->get('controller/check_phpextension_success');
        $failMessage = $this->namespace->get('controller/check_phpextension_failure');

        if (extension_loaded($requiredExtesion)) {
            return array(
                'type' => self::CHECK_TYPE,
                'errorLevel' => Validation::REQUIREMENT_VALID,
                'message'    => sprintf(
                    $successMessage,
                    $requiredExtesion
                )
            );
        } else {
            return array(
                'type' => self::CHECK_TYPE,
                'errorLevel' => $requirement['level'],
                'message'    => sprintf(
                    $failMessage,
                    $requiredExtesion
                )
            );
        }
    }
}
