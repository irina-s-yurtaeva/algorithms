public class SingleDictionary<K, V> implements Dictionary<K, V>
{
	protected K[] keys = (K[]) new Object[0];
	protected V[] vals = (V[]) new Object[0];

	@Override
	public void put(K key, V value)
	{
		this.resize();
		this.keys[this.getSize() - 1] = key;
		this.vals[this.getSize() - 1] = value;
	}

	@Override
	public V get(K key)
	{
		for (int i = 0; i < this.getSize(); i++)
		{
			if (key.equals(this.keys[i]))
			{
				return this.vals[i];
			}
		}
		return null;
	}

	@Override
	public V del(K key)
	{
		V result = null;
		int index = 0;
		for (int i = 0; i < this.getSize(); i++)
		{
			if (key.equals(this.keys[i]))
			{
				result = this.vals[i];
				index = i;
				break;
			}
		}
		if (result != null)
		{
			K[] newKeys = (K[]) new Object[this.keys.length - 1];
			V[] newVals = (V[]) new Object[this.keys.length - 1];
			System.arraycopy(this.keys, 0, newKeys, 0, index);
			System.arraycopy(this.keys, index + 1, newKeys, index, this.keys.length - 1 - index);
			System.arraycopy(this.vals, 0, newVals, 0, index);
			System.arraycopy(this.vals, index + 1, newVals, index, this.keys.length - 1 - index);

			this.keys = newKeys;
			this.vals = newVals;
		}

		return result;
	}

	protected void resize()
	{
		K[] newKeys = (K[]) new Object[this.getSize() + 1];
		V[] newVals = (V[]) new Object[this.getSize() + 1];
		for (int i = 0; i < this.keys.length; i++)
		{
			newKeys[i] = this.keys[i];
			newVals[i] = this.vals[i];
		}
		this.keys = newKeys;
		this.vals = newVals;
	}

	public int getSize()
	{
		return this.keys.length;
	}

	public int getPointer()
	{
		return this.keys.length;
	}

	public boolean isEmpty()
	{
		return false;
	}
}
