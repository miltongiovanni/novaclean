<?php

namespace App\Controller;

use App\Entity\Perfiles;
use App\Entity\Permission;
use App\Repository\PerfilesRepository;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/permisos')]
class PermissionController extends AbstractController
{
    public const MODULOS = ['ADMINISTRACIÓN', 'CONFIGURACIÓN', 'PERSONAL', 'CONTRATO', 'NÓMINA', 'COMPRAS', 'PROVEEDORES', 'CLIENTES', 'TESORERÍA', 'CARTERA',  'INVENTARIOS', 'VENTAS', 'HISTÓRICO'];

    #[Route('/', name: 'permission_index', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository, PerfilesRepository $perfilesRepository): Response
    {
        return $this->render('permission/index.html.twig', [
            'perfiles' => $perfilesRepository->findAll(),
        ]);
    }

    #[Route('/{slug}', name: 'permission_show', methods: ['GET'])]
    public function show(PerfilesRepository $perfilesRepository, string $slug, PermissionRepository $permissionRepository): Response
    {
        $perfil = $perfilesRepository->findOneBy(['slug' => $slug]);
        $permisosActivos = $permissionRepository->findByPerfilId($perfil->getId());
        if (count($permisosActivos) > 0){
            foreach ($permisosActivos as $permisoActivo){
                $permisosActivosFormato[$permisoActivo['atributo'].'_'.$permisoActivo['modulo']]=$permisoActivo['activo']? '1': '0';
            }
        }else{
            $permisosActivosFormato = null;
        }

        return $this->render('permission/show.html.twig', [
            'permisos' => $permisosActivosFormato,
            'perfil' => $perfil,
            'modulos' => $this::MODULOS,
        ]);
    }

    #[Route('/{slug}/edit', name: 'permission_edit', methods: ['POST'])]
    public function edit(Request $request, string $slug, PerfilesRepository $perfilesRepository, PermissionRepository $permissionRepository): Response
    {
        $perfil = $perfilesRepository->findOneBy(['slug' => $slug]);
        $permisosSeleccionados = $request->request->all('permisos');
        $permisosActivos = $permissionRepository->findByPerfilId($perfil->getId());
        $permisosActivosFormato=[];
        foreach ($permisosActivos as $permisoActivo){
            $permisosActivosFormato[$permisoActivo['atributo'].'_'.$permisoActivo['modulo']]=$permisoActivo['activo']? '1': '0';
        }
        foreach ($permisosSeleccionados as $key => $permisoSeleccionado){
            $permiso_atr = explode('_', $key);
            $permiso = $permissionRepository->findOneByPerfilId($perfil->getId(), $permiso_atr[0], $permiso_atr[1]) ?? new Permission();
            $permiso->setPerfil($perfil);
            $permiso->setAtributo($permiso_atr[0]);
            $permiso->setModulo($permiso_atr[1]);
            $permiso->setFechaCreacion(date_create());
            $permiso->setFechaActualizacion(date_create());
            $permiso->setActivo($permisoSeleccionado);
            $permissionRepository->save($permiso, true);
        }
        foreach ($permisosActivosFormato as $key => $permisoActivoFormato){
            if (!array_key_exists($key, $permisosSeleccionados)){
                $permiso_atr = explode('_', $key);
                $permiso = $permissionRepository->findOneByPerfilId($perfil->getId(), $permiso_atr[0], $permiso_atr[1]);
                $permiso->setPerfil($perfil);
                $permiso->setAtributo($permiso_atr[0]);
                $permiso->setModulo($permiso_atr[1]);
                $permiso->setFechaCreacion(date_create());
                $permiso->setFechaActualizacion(date_create());
                $permiso->setActivo(false);
                $permissionRepository->save($permiso, true);
            }

        }
        $this->addFlash('success', 'Permisos asignados correctamente');
        return $this->redirectToRoute('permission_show', ['slug'=>$perfil->getSlug()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'permission_delete', methods: ['POST'])]
    public function delete(Request $request, Permission $permission, PermissionRepository $permissionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $permission->getId(), $request->request->get('_token'))) {
            $permissionRepository->remove($permission, true);
        }

        return $this->redirectToRoute('permission_index', [], Response::HTTP_SEE_OTHER);
    }
}
