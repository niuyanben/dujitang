<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 2.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Caching Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		EllisLab Dev Team
 * @link
 */
class CI_Cache extends CI_Driver_Library {

	/**
	 * Valid cache drivers
	 *
	 * @var array
	 */
	protected $valid_drivers = array(
		'apc',
		'dummy',
		'file',
		'memcached',
		'redis',
		'wincache'
	);

	/**
	 * Path of cache files (if file-based cache)
	 *
	 * @var string
	 */
	protected $_cache_path = NULL;

	/**
	 * Reference to the driver
	 *
	 * @var mixed
	 */
	protected $_adapter = 'dummy';

	/**
	 * Fallback driver
	 *
	 * @var string
	 */
	protected $_backup_driver = 'dummy';

	/**
	 * Cache key prefix
	 *
	 * @var	string
	 */
	public $key_prefix = '';

	/**
	 * Constructor
	 *
	 * Initialize class properties based on the configuration array.
	 *
	 * @param	array	$config = array()
	 * @return	void
	 */
	public function __construct($config = array())
	{
		isset($config['adapter']) && $this->_adapter = $config['adapter'];
		isset($config['backup']) && $this->_backup_driver = $config['backup'];
		isset($config['key_prefix']) && $this->key_prefix = $config['key_prefix'];

		// If the specified adapter isn't available, check the backup.
		if ( ! $this->is_supported($this->_adapter))
		{
			if ( ! $this->is_supported($this->_backup_driver))
			{
				// Backup isn't supported either. Default to 'Dummy' driver.
				log_message('error', 'Cache adapter "'.$this->_adapter.'" and backup "'.$this->_backup_driver.'" are both unavailable. Cache is now using "Dummy" adapter.');
				$this->_adapter = 'dummy';
			}
			else
			{
				// Backup is supported. Set it to primary.
				log_message('debug', 'Cache adapter "'.$this->_adapter.'" is unavailable. Falling back to "'.$this->_backup_driver.'" backup adapter.');
				$this->_adapter = $this->_backup_driver;
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get
	 *
	 * Look for a value in the cache. If it exists, return the data
	 * if not, return FALSE
	 *
	 * @param	string	$id
	 * @return	mixed	value matching $id or FALSE on failure
	 */
	public function get($id)
	{
		return $this->{$this->_adapter}->get($this->key_prefix.$id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Save
	 *
	 * @param	string	$id	Cache ID
	 * @param	mixed	$data	Data to store
	 * @param	int	$ttl	Cache TTL (in seconds)
	 * @param	bool	$raw	Whether to store the raw value
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function save($id, $data, $ttl = 60, $raw = FALSE)
	{
		return $this->{$this->_adapter}->save($this->key_prefix.$id, $data, $ttl, $raw);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete from Cache
	 *
	 * @param	string	$id	Cache ID
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function delete($id)
	{
		return $this->{$this->_adapter}->delete($this->key_prefix.$id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Increment a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to add
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function increment($id, $offset = 1)
	{
		return $this->{$this->_adapter}->increment($this->key_prefix.$id, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Decrement a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to reduce by
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function decrement($id, $offset = 1)
	{
		return $this->{$this->_adapter}->decrement($this->key_prefix.$id, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Clean the cache
	 *
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function clean()
	{
		return $this->{$this->_adapter}->clean();
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Info
	 *
	 * @param	string	$type = 'user'	user/filehits
	 * @return	mixed	array containing cache info on success OR FALSE on failure
	 */
	public function cache_info($type = 'user')
	{
		return $this->{$this->_adapter}->cache_info($type);
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Cache Metadata
	 *
	 * @param	string	$id	key to get cache metadata on
	 * @return	mixed	cache item metadata
	 */
	public function get_metadata($id)
	{
		return $this->{$this->_adapter}->get_metadata($this->key_prefix.$id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Is the requested driver supported in this environment?
	 *
	 * @param	string	$driver	The driver to test
	 * @return	array
	 */
	public function is_supported($driver)
	{
		static $support;

		if ( ! isset($support, $support[$driver]))
		{
			$support[$driver] = $this->{$driver}->is_supported();
		}

		return $support[$driver];
	}
	
	
	public function exists($id)
    {
        return $this->{$this->_adapter}->exists($id);
    }
    public function rename($id, $reid)
    {
        return $this->{$this->_adapter}->rename($id, $reid);
    }
    public function expire($id, $sec)
    {
        return $this->{$this->_adapter}->expire($id, $sec);
    }
    public function ttl($id)
    {
        return $this->{$this->_adapter}->ttl($id);
    }
    public function keys($pattern)
    {
        return $this->{$this->_adapter}->keys($pattern);
    }
    public function hkeys($id)
    {
        return $this->{$this->_adapter}->hkeys($id);
    }
    public function hvals($id)
    {
        return $this->{$this->_adapter}->hvals($id);
    }
    public function hgetall($id)
    {
        return $this->{$this->_adapter}->hgetall($id);
    }
    public function hget($id, $subId)
    {
        return $this->{$this->_adapter}->hget($id, $subId);
    }
    public function hset($id, $subId, $data)
    {
        return $this->{$this->_adapter}->hset($id, $subId, $data);
    }
    public function hlen($id)
    {
        return $this->{$this->_adapter}->hlen($id);
    }
    public function hmget($id, $data)
    {
        return $this->{$this->_adapter}->hmget($id, $data);
    }
    public function hmset($id, $data)
    {
        return $this->{$this->_adapter}->hmset($id, $data);
    }
    public function hdel($id, $subId)
    {
        return $this->{$this->_adapter}->hdel($id, $subId);
    }
    public function hincr($id, $subId, $data)
    {
        return $this->{$this->_adapter}->hincr($id, $subId, $data);
    }
    public function sadd($id, $value)
    {
        return $this->{$this->_adapter}->sadd($id, $value);
    }
    public function smembers($id)
    {
        return $this->{$this->_adapter}->smembers($id);
    }
    public function srandmember($id, $count = 1)
    {
        return $this->{$this->_adapter}->srandmember($id, $count);
    }
    public function srem($id, $value)
    {
        return $this->{$this->_adapter}->srem($id, $value);
    }
    public function zadd($id, $score, $value)
    {
        return $this->{$this->_adapter}->zadd($id, $score, $value);
    }
    public function zincrby($id, $score, $value)
    {
        return $this->{$this->_adapter}->zincrby($id, $score, $value);
    }
    public function zrange($id, $start, $end, $options)
    {
        return $this->{$this->_adapter}->zrange($id, $start, $end, $options);
    }
    public function zrevrange($id, $start, $end, $options)
    {
        return $this->{$this->_adapter}->zrevrange($id, $start, $end, $options);
    }
    public function zrangebyscore($id, $startScore, $endScore, $options)
    {
        return $this->{$this->_adapter}->zrangebyscore($id, $startScore, $endScore, $options);
    }
    public function zrank($id, $member)
    {
        return $this->{$this->_adapter}->zrank($id, $member);
    }
    public function zrevrank($id, $member)
    {
        return $this->{$this->_adapter}->zrevrank($id, $member);
    }
    public function zscore($id, $member)
    {
        return $this->{$this->_adapter}->zscore($id, $member);
    }
    public function zrem($id, $value)
    {
        return $this->{$this->_adapter}->zrem($id, $value);
    }
    public function rpop($id)
    {
        return $this->{$this->_adapter}->rpop($id);
    }
    public function lpop($id)
    {
        return $this->{$this->_adapter}->lpop($id);
    }
    public function rpush($id, $value)
    {
        return $this->{$this->_adapter}->rpush($id, $value);
    }
    public function lpush($id, $value)
    {
        return $this->{$this->_adapter}->lpush($id, $value);
    }
    public function lrange($id, $start, $end)
    {
        return $this->{$this->_adapter}->lrange($id, $start, $end);
    }
    public function ltrim($id, $start, $end)
    {
        return $this->{$this->_adapter}->ltrim($id, $start, $end);
	}
	
	function incr($key, $offset = 1, $ttl = 86400)
    {
        $incr =$this->{$this->_adapter}->increment($key, $offset);
        if ($incr == $offset) {
            $this->{$this->_adapter}->expire($key, $ttl);
        }
        return $incr;
    }
}
