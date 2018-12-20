<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Pagination\Pagination;
use AppBundle\Entity\EntityMerger;
use AppBundle\Entity\Product;
use AppBundle\Entity\Tag;
use AppBundle\Exception\ValidationException;
use AppBundle\Resource\Filtering\Product\ProductFilterDefinitionFactory;
use AppBundle\Resource\Filtering\Tag\TagFilterDefinitionFactory;
use AppBundle\Resource\Pagination\Product\ProductPagination;
use AppBundle\Resource\Pagination\PageRequestFactory;
use AppBundle\Resource\Pagination\Tag\TagPagination;
use FOS\HttpCacheBundle\Configuration\InvalidateRoute;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\ControllerTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Security("is_anonymous() or is_authenticated()")
 */
class ProductsController extends AbstractController
{
    use ControllerTrait;

    /**
     * @var EntityMerger
     */
    private $entityMerger;
    /**
     * @var ProductPagination
     */
    private $productPagination;
    /**
     * @var TagPagination
     */
    private $tagPagination;

    /**
     * @param EntityMerger $entityMerger
     * @param Pagination $pagination
     */
    public function __construct(EntityMerger $entityMerger, ProductPagination $productPagination, TagPagination $tagPagination)
    {
        $this->entityMerger = $entityMerger;
        $this->productPagination = $productPagination;
        $this->tagPagination = $tagPagination;
    }

    /**
     * @Rest\View()
     * @SWG\Get(
     *     tags={"Product"},
     *     summary="Gets all product",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(response="200", description="Returned when successful", @SWG\Schema(type="array", @Model(type=Product::class))),
     *     @SWG\Response(response="404", description="Returned when product is not found")
     * )
     */
    public function getProductsAction(Request $request)
    {
        $pageRequestFactory = new PageRequestFactory();
        $page = $pageRequestFactory->fromRequest($request);

        $productFilterDefinitionFactory = new ProductFilterDefinitionFactory();
        $productFilterDefinition = $productFilterDefinitionFactory->factory($request);

        return $this->productPagination->paginate(
            $page,
            $productFilterDefinition
        );
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("product", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     * @SWG\Post(
     *     tags={"Product"},
     *     summary="Add a new product resource",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="body", in="body", required=true, @SWG\Schema(type="array", @Model(type=Product::class))),
     *     @SWG\Response(response="201", description="Returned when resource created", @SWG\Schema(type="array", @Model(type=Product::class))),
     *     @SWG\Response(response="400", description="Returned when invalid date posted"),
     *     @SWG\Response(response="401", description="Returned when not authenticated"),
     *     @SWG\Response(response="403", description="Returned when token is invalid or expired")
     * )
     */
    public function postProductsAction(Product $product, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        $em = $this->getDoctrine()
            ->getManager();
        $em->persist($product);
        $em->flush();

        return $product;
    }

    /**
     * @Rest\View()
     * @InvalidateRoute("get_product", params={"product" = {"expression" = "product.getId()"}})
     * @InvalidateRoute("get_products")
     * @SWG\Delete(
     *     tags={"Product"},
     *     summary="Delete the product",
     *     @SWG\Parameter(name="product", in="path", type="integer", description="Product id", required=true),
     *     @SWG\Response(response="200", description="Returned when successful", @SWG\Schema(type="array", @Model(type=Product::class))),
     *     @SWG\Response(response="404", description="Returned when product is not found")
     * )
     * @Security("is_granted('delete', product)")
     */
    public function deleteProductAction(?Product $product)
    {
        if (null === $product) {
            return $this->view(null, 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
    }

    /**
     * @Rest\View()
     * @Cache(public=true, maxage=3600, smaxage=3600)
     * @SWG\Get(
     *     tags={"Product"},
     *     summary="Gets the product",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="product", in="path", type="integer", description="Product id", required=true),
     *     @SWG\Response(response="200", description="Returned when successful", @SWG\Schema(type="array", @Model(type=Product::class))),
     *     @SWG\Response(response="404", description="Returned when product is not found")
     * )
     */
    public function getProductAction(?Product $product)
    {
        if (null === $product) {
            return $this->view(null, 404);
        }

        return $product;
    }

    /**
     * @Rest\View()
     */
    public function getProductTagsAction(Request $request, Product $product)
    {
        $pageRequestFactory = new PageRequestFactory();
        $page = $pageRequestFactory->fromRequest($request);

        $tagFilterDefinitionFactory = new TagFilterDefinitionFactory();
        $tagFilterDefinition = $tagFilterDefinitionFactory->factory(
            $request,
            $product->getId()
        );

        return $this->tagPagination->paginate(
            $page,
            $tagFilterDefinition
        );
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("tag", converter="fos_rest.request_body", options={"deserializationContext"={"groups"={"Deserialize"}}})
     * @Rest\NoRoute()
     */
    public function postProductTagsAction(Product $product, Tag $tag, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        $tag->setProduct($product);

        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);

        $product->getTags()->add($tag);
        $em->persist($product);
        
        $em->flush();

        return $tag;
    }

    /**
     * @Rest\NoRoute()
     * @ParamConverter("modifiedProduct", converter="fos_rest.request_body", options={"validator" = {"groups" = {"Patch"}}})
     * @Security("is_authenticated()")
     * @SWG\Patch(
     *     tags={"Product"},
     *     summary="Update the product",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="product", in="path", type="integer", description="Product id", required=true),
     *     @SWG\Response(response="200", description="Returned when successful", @SWG\Schema(type="array", @Model(type=Product::class))),
     *     @SWG\Response(response="404", description="Returned when product is not found")
     * )
     */
    public function patchProductAction(?Product $product, Product $modifiedProduct, ConstraintViolationListInterface $validationErrors)
    {
        if (null === $product) {
            return $this->view(null, 404);
        }

        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        // Merge entities
        $this->entityMerger->merge($product, $modifiedProduct);

        // Persist
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        // Return
        return $product;
    }
}