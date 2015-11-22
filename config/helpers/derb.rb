require 'erb'

# Directory Erb
module DErb
  def self.erbize(source, binding)
    raise "Need block" unless block_given?
    source = [source] unless source.is_a? Array
    source.each do |dir|
      Dir.glob(File.join(dir, "**", "*")).each do |f|
        yield(f.split('/').slice((dir.split('/').count)..-1).join('/'), ERB.new(File.read(f)).result(binding)) if File.file? f
      end
    end
  end
end
