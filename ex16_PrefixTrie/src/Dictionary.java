public interface Dictionary<K, V>
{
	public void put(K key, V value);
	public V get(K key);

	int getSize();
	int getPointer();

	boolean isEmpty();
}
