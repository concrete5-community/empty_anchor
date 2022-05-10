<?php

namespace Concrete\Package\EmptyAnchor\Block\EmptyAnchor;

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Error\UserMessageException;
use Exception;
use Throwable;

defined('C5_EXECUTE') or die('Access denied.');

class Controller extends BlockController
{
    /**
     * The regular expression to be used to check if an ID is valid.
     * HTML5 is more permissive, but let's adopt HTML4 rules for better compatibility.
     *
     * @see https://www.w3.org/TR/html4/types.html#type-id
     */
    const RX_VALID_ID = '^[A-Za-z][A-Za-z0-9\-_:.]*$';

    /**
     * The maximum length (in characters) of an anchor name.
     *
     * @var int
     */
    const ID_MAX_LENGTH = 255;

    /**
     * The anchor name.
     *
     * @var string|null
     */
    public $anchorName;

    /**
     * The Y offset of the anchor.
     *
     * @var int|string|null
     */
    public $offsetY;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btTable
     */
    protected $btTable = 'btEmptyAnchor';

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btInterfaceWidth
     */
    protected $btInterfaceWidth = 500;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btInterfaceHeight
     */
    protected $btInterfaceHeight = 390;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btCacheBlockRecord
     */
    protected $btCacheBlockRecord = true;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btCacheBlockOutput
     */
    protected $btCacheBlockOutput = true;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btCacheBlockOutputOnPost
     */
    protected $btCacheBlockOutputOnPost = true;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$btCacheBlockOutputForRegisteredUsers
     *
     * We need to disable cache for registered users because when in edit mode we need to display a different HTML.
     */
    protected $btCacheBlockOutputForRegisteredUsers = false;

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$helpers
     */
    protected $helpers = [];

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::$supportSavingNullValues
     */
    protected $supportSavingNullValues = true;

    public function getBlockTypeName()
    {
        return t('Empty Anchor');
    }

    public function getBlockTypeDescription()
    {
        return t('Add a simple empty anchor to your webpage.');
    }

    public function registerViewAssets($outputContent = '')
    {
        if ($this->isPageInEditMode()) {
            $this->requireAsset('css', 'font-awesome');
        }
    }

    public function add()
    {
        $this->edit();
    }

    public function edit()
    {
        $this->set('form', $this->app->make(Form::class));
        $this->set('rxValidID', static::RX_VALID_ID);
        $this->set('idMaxLength', static::ID_MAX_LENGTH);
        $this->set('validAnchorMessage', $this->getValidAnchorMessageDescription());
        $this->set('anchorName', (string) $this->anchorName);
        $this->set('offsetY', $this->offsetY ? (int) $this->offsetY : 0);
    }

    public function view()
    {
        $this->set('isPageInEditMode', $this->isPageInEditMode());
        $this->set('offsetY', (int) $this->offsetY);
    }
    
    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::validate()
     */
    public function validate($data)
    {
        $check = $this->normalize($data);

        return is_array($check) ? null : $check;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Block\BlockController::save()
     */
    public function save($data)
    {
        $data = $this->normalize($data);
        if (!is_array($data)) {
            throw new UserMessageException(implode("\n", $data->getList()));
        }
        parent::save($data);
    }

    /**
     * @return string
     */
    private static function getValidAnchorMessageDescription()
    {
        return t('The name of an anchor must start with a letter, and may be followed by any number of letters, digits, hyphens, underscores, colons, and periods.');
    }

    /**
     * @param array|mixed $data
     *
     * @return array|\Concrete\Core\Error\ErrorList\ErrorList
     */
    private function normalize($data)
    {
        $data = (is_array($data) ? $data : []) + [
            'anchorName' => '',
            'offsetY' => null,
        ];
        $normalized = [];
        $errors = $this->app->make('error');
        $normalized['anchorName'] = is_string($data['anchorName']) ? trim($data['anchorName']) : '';
        if ($normalized['anchorName'] === '') {
            $errors->add(t('Please specify the anchor name.'));
        } elseif (!preg_match('/' . static::RX_VALID_ID . '/', $normalized['anchorName'])) {
            $errors->add(t('The name of the anchor is not valid.') . "\n" . $this->getValidAnchorMessageDescription());
        } elseif (strlen($normalized['anchorName']) > static::ID_MAX_LENGTH) {
            $errors->add(t('The maximum length of the anchor name is %s characters.', static::ID_MAX_LENGTH));
        }
        if ($data['offsetY'] === '' || $data['offsetY'] === null) {
            $normalized['offsetY'] = 0;
        } elseif (!is_int($data['offsetY']) && !(is_string($data['offsetY']) && preg_match('/^[\-+]?\d{1,9}$/', $data['offsetY']))) {
            $errors->add(t('The vertical offset is invalid'));
        } else {
            $normalized['offsetY'] = (int) $data['offsetY'];
        }

        return $errors->has() ? $errors : $normalized;
    }

    /**
     * @return bool
     */
    private function isPageInEditMode()
    {
        try {
            if ($this->request) {
                $page = $this->request->getCurrentPage();
                if ($page && $page->isEditMode()) {
                    return true;
                }
            }
        } catch (Exception $x) {
        } catch (Throwable $x) {
        }

        return false;
    }
}
