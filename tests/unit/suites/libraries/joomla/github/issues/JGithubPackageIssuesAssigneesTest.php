<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-28 at 22:12:11.
 */
class JGithubPackageIssuesAssigneesTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  11.4
	 */
	protected $options;

	/**
	 * @var    JGithubHttp  Mock client object.
	 * @since  11.4
	 */
	protected $client;

	/**
	 * @var    JHttpResponse  Mock response object.
	 * @since  12.3
	 */
	protected $response;

	/**
	 * @var JGithubPackageIssuesAssignees
	 */
	protected $object;

	protected $owner = 'joomla';

	protected $repo = 'joomla-platform';

	/**
	 * Tests the getList method
	 *
	 * @return void
	 */
	public function testGetList()
	{
		$this->response->code = 200;
		$this->response->body = '[
	{
	"login": "octocat",
	"id": 1,
	"avatar_url": "https://github.com/images/error/octocat_happy.gif",
	"gravatar_id": "somehexcode",
	"url": "https://api.github.com/users/octocat"
	}
	]';

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees', 0, 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList($this->owner, $this->repo),
			$this->equalTo(json_decode($this->response->body))
		);
	}

	/**
	 * Tests the getList method
	 * Response:
	 * If the given assignee login belongs to an assignee for the repository,
	 * a 204 header with no content is returned.
	 * Otherwise a 404 status code is returned.
	 *
	 * @return void
	 */
	public function testCheck()
	{
		$this->response->code = 204;
		$this->response->body = '';

		$assignee = 'elkuku';

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees/' . $assignee, 0, 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check($this->owner, $this->repo, $assignee),
			$this->equalTo(true)
		);
	}

	/**
	 * Tests the getList method with a negative response
	 * Response:
	 * If the given assignee login belongs to an assignee for the repository,
	 * a 204 header with no content is returned.
	 * Otherwise a 404 status code is returned.
	 *
	 * @return void
	 */
	public function testCheckNo()
	{
		$this->response->code = 404;
		$this->response->body = '';

		$assignee = 'elkuku';

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees/' . $assignee, 0, 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check($this->owner, $this->repo, $assignee),
			$this->equalTo(false)
		);
	}

	/**
	 * Tests the getList method with a negative response
	 * Response:
	 * If the given assignee login belongs to an assignee for the repository,
	 * a 204 header with no content is returned.
	 * Otherwise a 404 status code is returned.
	 *
	 * @expectedException DomainException
	 *
	 * @return void
	 */
	public function testCheckException()
	{
		$this->response->code = 666;
		$this->response->body = '';

		$assignee = 'elkuku';

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/' . $this->owner . '/' . $this->repo . '/assignees/' . $assignee, 0, 0)
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->check($this->owner, $this->repo, $assignee),
			$this->equalTo(false)
		);
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options  = new JRegistry;
		$this->client   = $this->getMock('JGithubHttp', array('get', 'post', 'delete', 'patch', 'put'));
		$this->response = $this->getMock('JHttpResponse');

		$this->object = new JGithubPackageIssuesAssignees($this->options, $this->client);
	}

}
