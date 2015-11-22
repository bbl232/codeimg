require 'yaml'
require 'erb'
require 'highline'

class InteractiveBinding
  def initialize(hintsfile = nil, use_default = "false")
    @hints = (YAML.load(ERB.new(File.read(hintsfile)).result) if hintsfile) || {}
    @use_default = use_default
  end
  
  def fetch(sym, default) 
    (self.send(sym) if defined? sym) || default
  end
  
  def method_missing(sym, *args)
    value = value_for(sym.to_s)
    self.class.send :define_method, sym do
      value
    end
    value
  end
  
  def value_for(sym)
    hint = @hints[sym] || {}
    return hint["value"] if hint.has_key? "value"
    return hint["default"] if hint.has_key? "default" and @use_default == "true"
    HighLine.new.ask("Value for #{hint["prompt"] || sym}: ") do |q|
      q.default = hint["default"]
      if hint["default"].is_a?(TrueClass) || hint["default"].is_a?(FalseClass)
        q.answer_type = lambda { |answer| answer =~ /true/ }
      end
    end
  end
  
  def get_binding
    binding
  end
end
