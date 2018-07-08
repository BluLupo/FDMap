<?php
 
namespace App\EventListener;
 
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CredentialsService; 

class AuthenticationListener
{
	protected $credentialsService;

	public function __construct(CredentialsService $credentialsService)
	{
		$this->credentialsService = $credentialsService;
	}

	/**
	 * onAuthenticationFailure
	 *
	 * @author 	Joe Sexton <joe@webtipblog.com>
	 * @param 	AuthenticationFailureEvent $event
	 */
	public function onAuthenticationFailure( AuthenticationFailureEvent $event )
	{
		$login = $event->getAuthenticationToken()->getUser();
		$this->credentialsService->updateCredentials($login);
	}
 
	/**
	 * onAuthenticationSuccess
	 *
	 * @author 	Joe Sexton <joe@webtipblog.com>
	 * @param 	InteractiveLoginEvent $event
	 */
	public function onAuthenticationSuccess( InteractiveLoginEvent $event)
    {
    	$login = $event->getRequest()->request->all()['_username'];
        $this->credentialsService->updateCredentials($login);
    }
}