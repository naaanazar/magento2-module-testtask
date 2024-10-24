<?php

declare(strict_types=1);

namespace Nakor\TestTask\Controller\Hobby;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Validator\Exception as ValidatorException;
use Nakor\TestTask\Helper\Data;

class EditPost implements HttpPostActionInterface
{
    /**
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param CurrentCustomer $currentCustomer
     * @param CustomerRepositoryInterface $customerRepository
     * @param ManagerInterface $messageManager
     * @param UrlInterface $url
     * @param Validator $formKeyValidator
     * @param Data $data
     */
    public function __construct(
        protected ResultFactory $resultFactory,
        protected RequestInterface $request,
        protected CurrentCustomer $currentCustomer,
        protected CustomerRepositoryInterface $customerRepository,
        protected ManagerInterface $messageManager,
        protected UrlInterface $url,
        protected Validator $formKeyValidator,
        protected Data $data
    ) {
    }

    /**
     * Save Edit Hobby
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $hobby = $this->request->getParam(Data::HOBBY_ATTR_CODE);
        try {
            if (!$this->formKeyValidator->validate($this->request)
                || !$this->data->isValidHobbyOption($hobby)
            ) {
                throw new ValidatorException();
            }
            $this->currentCustomer->getCustomer();
            $customer = $this->currentCustomer->getCustomer();
            $customer->setCustomAttribute(Data::HOBBY_ATTR_CODE, $hobby);
            $this->customerRepository->save($customer);
            $this->messageManager->addSuccessMessage(__('Your hobby has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while saving your hobby.'));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->url->getUrl('testtask/hobby/edit'));

        return $resultRedirect;
    }
}
