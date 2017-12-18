<?php
/**
 * @author Ahmed Ammar <ahmed.a.ammar@gmail.com>
 *
 * @copyright Copyright (c) 2017, ownCloud GmbH
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */
namespace OCA\DAV\Tests\unit\Upload;

class FutureFileTestZsync extends \Test\TestCase {

	public function testGetContentType() {
		$f = $this->mockFutureFile();
		$this->assertEquals('application/octet-stream', $f->getContentType());
	}

	public function testGetETag() {
		$f = $this->mockFutureFile();
		$this->assertEquals('1234567890', $f->getETag());
	}

	public function testGetName() {
		$f = $this->mockFutureFile();
		$this->assertEquals('foo.txt', $f->getName());
	}

	public function testGetLastModified() {
		$f = $this->mockFutureFile();
		$this->assertEquals(12121212, $f->getLastModified());
	}

	public function testGetSize() {
		$f = $this->mockFutureFile();
		$this->assertEquals(0, $f->getSize());
	}

	public function testGet() {
		$f = $this->mockFutureFile();
		$stream = $f->get();
		$this->assertTrue(is_resource($stream));
	}

	public function testGetZsync() {
		$file = $this->createMock('Sabre\DAV\IFile');
		$f = $this->mockFutureFile();
		$f->setBackingFile($file);
		$f->setFileLength(1231);
		$stream = $f->get();
		$this->assertTrue(is_resource($stream));
	}

	public function testDelete() {
		$d = $this->getMockBuilder('OCA\DAV\Connector\Sabre\Directory')
			->disableOriginalConstructor()
			->setMethods(['delete'])
			->getMock();

		$d->expects($this->once())
			->method('delete');

		$f = new \OCA\DAV\Upload\FutureFileZsync($d, 'foo.txt');
		$f->delete();
	}

	/**
	 * @expectedException Sabre\DAV\Exception\Forbidden
	 */
	public function testPut() {
		$f = $this->mockFutureFile();
		$f->put('');
	}

	/**
	 * @expectedException Sabre\DAV\Exception\Forbidden
	 */
	public function testSetName() {
		$f = $this->mockFutureFile();
		$f->setName('');
	}

	/**
	 * @return \OCA\DAV\Upload\FutureFile
	 */
	private function mockFutureFile() {
		$d = $this->getMockBuilder('OCA\DAV\Connector\Sabre\Directory')
			->disableOriginalConstructor()
			->setMethods(['getETag', 'getLastModified', 'getChildren', 'childExists'])
			->getMock();

		$d->expects($this->any())
			->method('getETag')
			->willReturn('1234567890');

		$d->expects($this->any())
			->method('getLastModified')
			->willReturn(12121212);

		$d->expects($this->any())
			->method('getChildren')
			->willReturn([]);

		$d->expects($this->any())
			->method('childExists')
			->willReturn(true);

		return new \OCA\DAV\Upload\FutureFileZsync($d, 'foo.txt');
	}
}

