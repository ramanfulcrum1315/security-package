<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ReCaptchaNewsletter\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\ReCaptcha\Model\ConfigEnabledInterface;
use Magento\ReCaptcha\Model\ConfigInterface as ReCaptchaConfig;
use Magento\ReCaptchaFrontendUi\Model\ConfigInterface as ReCaptchaFrontendUiConfig;
use Magento\Store\Model\ScopeInterface;

/**
 * Return config flag "is recaptcha enabled for newsletter subscribe"
 */
class ConfigEnabled implements ConfigEnabledInterface
{
    public const XML_PATH_ENABLED_FOR_NEWSLETTER = 'recaptcha/frontend/enabled_for_newsletter';

    /**
     * @var ReCaptchaConfig
     */
    private $reCaptchaConfig;

    /**
     * @var ReCaptchaFrontendUiConfig
     */
    private $reCaptchaFrontendConfig;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ReCaptchaConfig $reCaptchaConfig
     * @param ReCaptchaFrontendUiConfig $reCaptchaFrontendConfig
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ReCaptchaConfig $reCaptchaConfig,
        ReCaptchaFrontendUiConfig $reCaptchaFrontendConfig,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->reCaptchaConfig = $reCaptchaConfig;
        $this->reCaptchaFrontendConfig = $reCaptchaFrontendConfig;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return true if enabled on frontend captcha for newsletter
     * @return bool
     */
    public function isEnabled(): bool
    {
        if (!$this->reCaptchaFrontendConfig->isFrontendEnabled() || !$this->reCaptchaConfig->isInvisibleRecaptcha()) {
            return false;
        }

        return (bool)$this->scopeConfig->getValue(
            static::XML_PATH_ENABLED_FOR_NEWSLETTER,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
