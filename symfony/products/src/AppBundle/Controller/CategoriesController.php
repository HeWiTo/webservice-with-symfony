<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Exception\ValidationException;
use AppBundle\Resource\Filtering\Category\CategoryFilterDefinitionFactory;
use AppBundle\Resource\Pagination\PageRequestFactory;
use AppBundle\Resource\Pagination\Category\CategoryPagination;
use FOS\RestBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations as Rest;


class CategoriesController extends AbstractController
{
    use ControllerTrait;

    /**
     * @var CategoryPagination
     */
    private $categoryPagination;

    public function __construct(CategoryPagination $categoryPagination)
    {
        $this->categoryPagination = $categoryPagination;
    }

    /**
     * @Rest\View()
     */
    public function getCategoriesAction(Request $request)
    {
        $categoryFilterDefinitionFactory = new CategoryFilterDefinitionFactory();
        $categoryFilterDefinition = $categoryFilterDefinitionFactory->factory($request);

        $pageRequestFactory = new PageRequestFactory();
        $page = $pageRequestFactory->fromRequest($request);

        return $this->categoryPagination->paginate($page, $categoryFilterDefinition);
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("category", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     */
    public function postCategoriesAction(Category $category, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return $category;
    }

    /**
     * @Rest\View()
     */
    public function deleteCategoryAction(?Category $category)
    {
        if (null === $category) {
            return $this->view(null, 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
    }

    /**
     * @Rest\View()
     */
    public function getCategoryAction(?Category $category)
    {
        if (null === $category) {
            return $this->view(null, 404);
        }

        return $category;
    }
}