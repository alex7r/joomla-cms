<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-29 at 14:24:37.
 */
class JGithubPackageRepositoriesKeysTest extends PHPUnit_Framework_TestCase
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
	 * @var JGithubPackageRepositoriesKeys
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  12.3
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  12.3
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * @covers JGithubPackageRepositoriesKeys::getList
	 *
	 * GET /repos/:owner/:repo/keys
	 *
	 * Response
	 *
	 * Status: 200 OK
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 *
	 * [
	 * {
	 * "id": 1,
	 * "key": "ssh-rsa AAA...",
	 * "url": "https://api.github.com/user/keys/1",
	 * "title": "octocat@octomac"
	 * }
	 * ]
	 */
	public function testGetList()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/keys')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesKeys::get
	 *
	 * GET /repos/:owner/:repo/keys/:id
	 *
	 * Response
	 *
	 * Status: 200 OK
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 *
	 * {
	 * "id": 1,
	 * "key": "ssh-rsa AAA...",
	 * "url": "https://api.github.com/user/keys/1",
	 * "title": "octocat@octomac"
	 * }
	 */
	public function testGet()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/keys/1')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 1),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesKeys::create
	 *
	 * POST /repos/:owner/:repo/keys
	 *
	 * Input
	 *
	 * {
	 * "title": "octocat@octomac",
	 * "key": "ssh-rsa AAA..."
	 * }
	 *
	 * Response
	 *
	 * Status: 201 Created
	 * Location: https://api.github.com/user/repo/keys/1
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 *
	 * {
	 * "id": 1,
	 * "key": "ssh-rsa AAA...",
	 * "url": "https://api.github.com/user/keys/1",
	 * "title": "octocat@octomac"
	 * }
	 */
	public function testCreate()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/keys')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->create('joomla', 'joomla-platform', 'email@example.com', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesKeys::edit
	 *
	 * PATCH /repos/:owner/:repo/keys/:id
	 *
	 * Input
	 *
	 * {
	 * "title": "octocat@octomac",
	 * "key": "ssh-rsa AAA..."
	 * }
	 *
	 * Response
	 *
	 * Status: 200 OK
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 *
	 * {
	 * "id": 1,
	 * "key": "ssh-rsa AAA...",
	 * "url": "https://api.github.com/user/keys/1",
	 * "title": "octocat@octomac"
	 * }
	 */
	public function testEdit()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('patch')
			->with('/repos/joomla/joomla-platform/keys/1')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->edit('joomla', 'joomla-platform', 1, 'email@example.com', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesKeys::delete
	 *
	 * DELETE /repos/:owner/:repo/keys/:id
	 *
	 * Response
	 *
	 * Status: 204 No Content
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 */
	public function testDelete()
	{
		$this->response->code = 204;
		$this->response->body = true;

		$this->client->expects($this->once())
			->method('delete')
			->with('/repos/joomla/joomla-platform/keys/1')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->delete('joomla', 'joomla-platform', 1),
			$this->equalTo($this->response->body)
		);
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @since   ¿
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options  = new JRegistry;
		$this->client   = $this->getMock('JGithubHttp', array('get', 'post', 'delete', 'patch', 'put'));
		$this->response = $this->getMock('JHttpResponse');

		$this->object = new JGithubPackageRepositoriesKeys($this->options, $this->client);
	}
}
