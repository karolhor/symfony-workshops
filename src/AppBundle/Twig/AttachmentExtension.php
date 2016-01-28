<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Attachment;
use Symfony\Component\Asset\Packages;

/**
 * Class AttachmentExtension
 */
class AttachmentExtension extends \Twig_Extension
{
    private $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('attachment', [$this, 'generateAttachment'], ['is_safe' => ['html']])
        ];
    }

    public function generateAttachment(Attachment $attachment)
    {
        $attachmentUrl = $this->packages->getUrl('uploads/attachments/'.$attachment->getFilename());

        if ($attachment->getMimeType() == 'image/png') {
            $template = sprintf('<a href="%s" class="thumbnail"><img src="%s" alt="%s"/></a>',
                $attachmentUrl, $attachmentUrl, $attachment->getName());
        } else {
            $pdfIcon = $this->packages->getUrl('images/pdf_48.png');
            $template = sprintf('<a href="%s" class="attachment"><img src="%s" />%s</a>',
                $attachmentUrl, $pdfIcon, $attachment->getName());
        }

        return $template;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'attachment_extension';
    }
}
